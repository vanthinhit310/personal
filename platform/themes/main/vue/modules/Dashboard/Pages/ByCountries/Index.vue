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
                    <highcharts :constructor-type="'mapChart'" :updateArgs="[true, false]" ref="countriesChart" :options="countriesChartOptions"></highcharts>
                </div>
            </a-col>
            <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>Specific Country</span></div>
                    <div class="form__group-input">
                        <el-select class="select--250" filterable @change="handleCountryChange" size="large" v-model="country" placeholder="Select countries">
                            <el-option v-for="(item, index) in countries" :label="`${item.name} (${item.iso})`" :key="index" :value="item.name">
                                <div class="country_with_flag">
                                    <span class="flag"><img class="img-fluid" :src="_.get(item, 'flag')" alt="Flag" /></span>
                                    <span>{{ `${item.name} (${item.iso})` }}</span>
                                </div>
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </a-col>
            <a-col :span="24">
                <div class="chart__wrap--content">
                    <a-spin tip="processing..." :spinning="processing">
                        <a-icon slot="indicator" type="sync" style="font-size: 20px" spin />
                        <a-row :gutter="16">
                            <a-col :md="{span: 12}" :span="24">
                                <a-timeline>
                                    <a-timeline-item>Population : {{ _.get(countryResult, 'population', 0) }}</a-timeline-item>
                                    <a-timeline-item>Cases : {{ _.get(countryResult, 'cases', 0) }}</a-timeline-item>
                                    <a-timeline-item>Deaths : {{ _.get(countryResult, 'deaths', 0) }}</a-timeline-item>
                                    <a-timeline-item>Recovered : {{ _.get(countryResult, 'recovered', 0) }}</a-timeline-item>
                                    <a-timeline-item>Active : {{ _.get(countryResult, 'active', 0) }}</a-timeline-item>
                                    <a-timeline-item>Today case : {{ _.get(countryResult, 'todayCases', 0) }}</a-timeline-item>
                                    <a-timeline-item>Today deaths : {{ _.get(countryResult, 'todayDeaths', 0) }}</a-timeline-item>
                                    <a-timeline-item>Today Recovered : {{ _.get(countryResult, 'todayRecovered', 0) }}</a-timeline-item>
                                    <a-timeline-item>Critical : {{ _.get(countryResult, 'critical', 0) }}</a-timeline-item>
                                    <a-timeline-item>Tests : {{ _.get(countryResult, 'tests', 0) }}</a-timeline-item>
                                </a-timeline>
                            </a-col>
                            <a-col :md="{span: 12}" :span="24">
                                <highcharts :constructor-type="'chart'" :updateArgs="[true, true, true]" ref="countryChart" :options="countryChartOptions"></highcharts>
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
            country: '',
            countryResult: '',
            countriesChartOptions: {
                chart: {
                    map: 'custom/world',
                    height: 500,
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
                    pointFormat:
                        '<span class="contry_flag"><img style="width:30px; height: auto;" src="{point.flag}"></span><span>{point.country}</span><br><span>Cases : {point.value}</span><br><span>Deaths : {point.deaths}</span><br><span>Recovered : {point.recovered}</span><br><span>Active : {point.active}</span>',
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
            countryChartOptions: {
                title: {
                    text: 'Covid-19 data tracking for specific country',
                },
                xAxis: {
                    categories: ['Cases', 'Deaths', 'Recovered', 'Active', 'Today case', 'Today deaths', 'Today Recovered', 'Critical', 'Tests'],
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'cases',
                        align: 'high',
                    },
                    labels: {
                        overflow: 'justify',
                    },
                },
                tooltip: {
                    valueSuffix: '',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true,
                        },
                        animation: {
                            duration: 1500,
                        },
                    },
                },
                credits: {
                    enabled: false,
                },
                series: [
                    {
                        name: "People cases",
                        type: 'column',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
                        colorByPoint: true,
                        showInLegend: false,
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
        ...mapActions('dashboard', ['allCountries', 'specificCountry']),
        async fetchDataAllCountries() {
            const response = await this.allCountries();
            const countries = response.data;
            if (!!countries) {
                this.countries = countries.map((o) => {
                    return {name: _.get(o, 'country'), iso: _.get(o, 'countryInfo.iso2'), flag: _.get(o, 'countryInfo.flag')};
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
        async trackingByCountry(country) {
            this.processing = true;
            this.$refs.countryChart.chart.showLoading();
            try {
                const response = await this.specificCountry(country);
                const countryResponse = _.get(response, 'data');
                if (!!countryResponse) {
                    this.countryResult = countryResponse;
                    const series = [
                        _.get(this.countryResult, 'cases', 0),
                        _.get(this.countryResult, 'deaths', 0),
                        _.get(this.countryResult, 'recovered', 0),
                        _.get(this.countryResult, 'active', 0),
                        _.get(this.countryResult, 'todayCases', 0),
                        _.get(this.countryResult, 'todayDeaths', 0),
                        _.get(this.countryResult, 'todayRecovered', 0),
                        _.get(this.countryResult, 'critical', 0),
                        _.get(this.countryResult, 'tests', 0),
                    ];
                    if (!!series) {
                        this.$refs.countryChart.chart.series[0].setData(series);
                    }
                } else {
                    this.countryResult = '';
                }
            } catch (err) {
                console.table(err);
            }
            this.$refs.countryChart.chart.hideLoading();
            this.processing = false;
        },
        async handleCountryChange() {
            try {
                if (!!this.country) {
                    await this.trackingByCountry(encodeURIComponent(this.country));
                }
            } catch (err) {
                console.table(err);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
