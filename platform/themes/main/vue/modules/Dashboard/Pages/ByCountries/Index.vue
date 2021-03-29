<template>
    <div class="chart__wrap">
        <a-row :gutter="[30, 30]">
            <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>All Countries</span></div>
                </div>
            </a-col>
            <a-col :span="24">
                <div class="chart__wrap--content">
                    <highcharts :constructor-type="'mapChart'" ref="countriesChart" :options="countriesChartOptions"></highcharts>
                </div>
            </a-col>
            <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>Specific Country</span></div>
                    <div class="form__group-input">
                        <el-select multiple filterable @change="handleCountriesChange" size="large" v-model="countriesSelected" placeholder="Select countries">
                            <el-option v-for="(item, index) in countries" :key="index" :label="`${item.name} (${item.iso})`" :value="item.name"> </el-option>
                        </el-select>
                    </div>
                </div>
            </a-col>
            <a-col :span="24">
                <div class="chart__wrap--content">
                    <a-spin tip="processing..." :spinning="processing">
                        <a-icon slot="indicator" type="sync" style="font-size: 20px" spin />
                        <a-row :gutter="16">
                            <a-col :span="24">
                                <div v-show="isShow">
                                    <a-card size="small" v-for="(o, i) in countriesResults" :key="i" :title="_.get(o, 'country')">
                                        <a-card-grid style="width: 25%; text-align: center"> Population : {{ _.get(o, 'population', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Cases : {{ _.get(o, 'cases', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Deaths : {{ _.get(o, 'deaths', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Recovered : {{ _.get(o, 'recovered', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Active : {{ _.get(o, 'active', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Today case : {{ _.get(o, 'todayCases', 0) }} </a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Today deaths : {{ _.get(o, 'todayDeaths', 0) }}</a-card-grid>
                                        <a-card-grid style="width: 25%; text-align: center"> Today Recovered : {{ _.get(o, 'todayRecovered', 0) }} </a-card-grid>
                                    </a-card>
                                </div>
                            </a-col>
                        </a-row>
                    </a-spin>
                </div>
            </a-col>
        </a-row>
    </div>
</template>

<script>
import {mapActions} from 'vuex';

export default {
    data() {
        return {
            processing: false,
            countries: [],
            countriesSelected: '',
            countriesResults: [],
            countriesChartOptions: {
                chart: {
                    map: 'custom/world',
                    height: 600,
                    events: {
                        load() {
                            this.showLoading('processing...');
                        },
                    },
                },
                title: {
                    text: 'Case of covid 19 all over the world!',
                },

                mapNavigation: {
                    enabled: true,
                    enableDoubleClickZoomTo: true,
                },
                plotOptions: {
                    area: {
                        color: '#beb697',
                    },
                    series: {
                        animation: {
                            duration: 2500,
                        },
                        marker: {
                            enabled: false,
                        },
                    },
                },
                tooltip: {
                    backgroundColor: 'none',
                    borderWidth: 0,
                    shadow: false,
                    useHTML: true,
                    padding: 20,
                    pointFormat: '<span class="contry_flag"><img style="width:30px; height: auto;" src="{point.flag}"></span><span>{point.country}</span><br><span>Cases : {point.value}</span><br><span>Deaths : {point.deaths}</span><br><span>Recovered : {point.recovered}</span><br><span>Active : {point.active}</span>',
                    positioner: function () {
                        return {x: 50, y: 270};
                    },
                },

                colorAxis: {
                    min: 1,
                    max: 50000000,
                    type: 'logarithmic',
                },

                series: [
                    {
                        data: [],
                        joinBy: ['iso-a3', 'code3'],
                        name: 'Covid 19 confirmed',
                        states: {
                            hover: {
                                color: '#a4edba',
                            },
                        },
                        tooltip: {
                            valueSuffix: ' cases',
                        },
                    },
                ],
            },
        };
    },
    computed: {
        isShow() {
            if (this.countriesResults instanceof Array && this.countriesResults.length > 0) {
                return true;
            }
            return false;
        },
    },
    async mounted() {
        try {
            await this.fetchDataAllCountries();
        } catch (err) {
            console.table(err);
        }
    },
    methods: {
        ...mapActions('dashboard', ['trackingByContinent', 'allCountries', 'multipleCountries']),
        async fetchDataAllCountries() {
            const response = await this.allCountries();
            const countries = response.data;
            if (!!countries) {
                this.countries = countries.map((o) => {
                    return {name: _.get(o, 'country'), iso: _.get(o, 'countryInfo.iso2')};
                });
                const seriesData = countries.map((o) => {
                    return {
                        name: _.get(o, 'country'),
                        value: _.get(o, 'cases', 0) < 1 ? 1 : _.get(o, 'cases', 0),
                        code: _.get(o, 'countryInfo.iso2'),
                        code3: _.get(o, 'countryInfo.iso3'),
                        country: _.get(o, 'country'),
                        flag: _.get(o, 'countryInfo.flag'),
                        deaths: _.get(o, 'deaths'),
                        recovered: _.get(o, 'recovered'),
                        active: _.get(o, 'active'),
                    };
                });
                if (!!seriesData) {
                    this.countriesChartOptions.series = {
                        data: seriesData,
                        joinBy: ['iso-a3', 'code3'],
                        name: 'Covid 19 confirmed',
                        states: {
                            hover: {
                                color: '#a4edba',
                            },
                        },
                        tooltip: {
                            valueSuffix: ' cases',
                        },
                    };
                    this.$refs.countriesChart.chart.hideLoading();
                }
            }
        },
        async fetchApiTracking(countries) {
            this.processing = true;
            try {
                const response = await this.multipleCountries(countries);
                const countriesResponse = _.get(response, 'data');
                if (!!countriesResponse) {
                    this.countriesResults = [...countriesResponse];
                }else{
                    this.countriesResults = [];
                }
            } catch (err) {
                console.table(err);
            }
            this.processing = false;
        },
        async handleCountriesChange() {
            try {
                const params = this.countriesSelected.map((o) => {
                    return encodeURIComponent(o);
                });
                if (!!params) {
                    await this.fetchApiTracking(params);
                }
            } catch (err) {
                console.table(err);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
