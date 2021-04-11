<template>
    <div class="chart__wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Covid-19 Historical Data by country</h1>
        </div>
        <a-row :gutter="[30, 30]">
            <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>Select country you want to show historical</span></div>
                    <div class="form__group-input">
                        <el-select class="select--250" filterable @change="handleCountryChange" size="large" v-model="country" placeholder="Select countries">
                            <el-option v-for="(item, index) in countriesOption" :label="`${item.name}`" :key="index" :value="item.numericCode">
                                <div class="country_with_flag">
                                    <span class="flag"><img class="img-fluid" :src="_.get(item, 'flag')" alt="Flag" /></span>
                                    <span>{{ `${item.name}` }}</span>
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
                        <a-row>
                            <a-col :span="24">
                                <highcharts :constructor-type="'chart'" :updateArgs="[true, true, true]" ref="histiricalChart" :options="historicalChartOption"></highcharts>
                            </a-col>
                        </a-row>
                    </a-spin>
                </div>
            </a-col>
        </a-row>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex';

export default {
    data() {
        return {
            countriesOption: [],
            country: '',
            lastDay: '5',
            processing: false,
            historicalChartOption: {
                chart: {
                    type: 'spline',
                },
                title: {
                    text: 'Snow depth at Vikjafjellet, Norway',
                },
                subtitle: {
                    text: 'Irregular time data in Highcharts JS',
                },
                xAxis: {
                    // type: 'datetime',
                    // // dateTimeLabelFormats: {
                    // //     // don't display the dummy year
                    // //     month: '%e. %b',
                    // //     year: '%b',
                    // // },
                    // title: {
                    //     text: 'Date',
                    // },
                },
                yAxis: {
                    title: {
                        text: 'Case (people)',
                    },
                    min: 0,
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y} case',
                },

                plotOptions: {
                    series: {
                        marker: {
                            enabled: true,
                        },
                    },
                },

                colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                series: [],

                responsive: {
                    rules: [
                        {
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                plotOptions: {
                                    series: {
                                        marker: {
                                            radius: 2.5,
                                        },
                                    },
                                },
                            },
                        },
                    ],
                },
            },
        };
    },
    async mounted() {
        this.fetchCountries();
    },
    methods: {
        ...mapActions('dashboard', ['countries', 'historicalByCountry']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async fetchCountries() {
            try {
                const response = await this.countries();
                const countries = _.get(response, 'data', []);
                if (!!countries) {
                    this.countriesOption = countries;
                }
            } catch (err) {
                console.table(err.message);
            }
        },
        async fetchHistoricalData(country, lastday) {
            this.processing = true;
            try {
                const response = await this.historicalByCountry({country, lastday});
                const timeline = _.get(response, 'data.timeline');
                if (!!timeline) {
                    /* cases */
                    let cases = _.get(timeline, 'cases');
                    if (!!cases) {
                        // format day string to timestamp
                        cases = Object.fromEntries(
                            Object.entries(cases).map(function ([key, value]) {
                                return [Date.parse(key), value];
                            })
                        );
                        // convert object to array
                        cases = Object.keys(cases).map((key) => [Number(key), cases[key]]);
                    }

                    /* recovered */
                    let recovered = _.get(timeline, 'recovered');
                    if (!!recovered) {
                        // format day string to timestamp
                        recovered = Object.fromEntries(
                            Object.entries(recovered).map(function ([key, value]) {
                                return [Date.parse(key), value];
                            })
                        );
                        // convert object to array
                        recovered = Object.keys(recovered).map((key) => [Number(key), recovered[key]]);
                    }

                    /* deaths */
                    let deaths = _.get(timeline, 'deaths');
                    if (!!deaths) {
                        // format day string to timestamp
                        deaths = Object.fromEntries(
                            Object.entries(deaths).map(function ([key, value]) {
                                return [Date.parse(key), value];
                            })
                        );
                        // convert object to array
                        deaths = Object.keys(deaths).map((key) => [Number(key), deaths[key]]);
                    }

                    const series = [
                        {
                            name: 'Cases',
                            data: [...cases],
                        },
                        {
                            name: 'Deaths',
                            data: [...deaths],
                        },
                        {
                            name: 'Recovered',
                            data: [...recovered],
                        },
                    ];
                    this.historicalChartOption.series = series;
                }
            } catch (err) {
                console.table(err.message);
            }
            this.processing = false;
        },
        async handleCountryChange() {
            try {
                if (!!this.country) {
                    await this.fetchHistoricalData(this.country, this.lastDay);
                }
            } catch (err) {
                console.table(err);
            }
        },
    },
};
</script>

<style scoped></style>
