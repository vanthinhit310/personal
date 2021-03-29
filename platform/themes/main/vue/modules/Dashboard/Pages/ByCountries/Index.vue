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
                    <highcharts :updateArgs="[true, false]" ref="countriesChart" :options="countriesChartOptions"></highcharts>
                </div>
            </a-col>
            <!-- <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>Specific Country</span></div>
                    <div class="form__group-input">
                        <el-select @change="handleContinentChange" size="large" v-model="continent" placeholder="Select continent">
                            <el-option v-for="(item, index) in continents" :key="index" :label="item" :value="item"> </el-option>
                        </el-select>
                    </div>
                </div>
            </a-col> -->
            <a-col :span="24">
                <div class="chart__wrap--content">
                    <a-spin tip="processing..." :spinning="processing">
                        <a-icon slot="indicator" type="sync" style="font-size: 20px" spin />
                        <!-- <a-row :gutter="[16, 16]">
                            <a-col :md="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Countries" :value="countCountries" :precision="0" suffix="countries" :value-style="{color: '#303133'}">
                                        <template #prefix>
                                            <a-icon type="global" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :md="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Population" :value="population" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#606266'}">
                                        <template #prefix>
                                            <a-icon type="solution" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Cases" :value="cases" :precision="0" suffix="people" :value-style="{color: '#E6A23C'}">
                                        <template #prefix>
                                            <a-icon type="team" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Deaths" :value="deaths" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#F56C6C'}">
                                        <template #prefix>
                                            <a-icon type="frown" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Recovered" :value="recovered" :precision="0" suffix="people" :value-style="{color: '#67C23A'}">
                                        <template #prefix>
                                            <a-icon type="heart" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Active" :value="active" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#409EFF'}">
                                        <template #prefix>
                                            <a-icon type="medicine-box" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Today Cases" :value="todayCases" :precision="0" suffix="people" :value-style="{color: '#2471A3'}">
                                        <template #prefix>
                                            <a-icon type="team" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Today Deaths" :value="todayDeaths" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#2471A3'}">
                                        <template #prefix>
                                            <a-icon type="frown" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Today Recovered" :value="todayRecovered" :precision="0" suffix="people" :value-style="{color: '#2471A3'}">
                                        <template #prefix>
                                            <a-icon type="heart" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                            <a-col :xl="{span: 6}" :lg="{span: 12}" :span="24">
                                <a-card>
                                    <a-statistic title="Critical" :value="critical" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#2471A3'}">
                                        <template #prefix>
                                            <a-icon type="medicine-box" />
                                        </template>
                                    </a-statistic>
                                </a-card>
                            </a-col>
                        </a-row> -->
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
            countriesChartOptions: {
                chart: {
                    map: 'custom/world',
                    height: '400',
                    events: {
                        load() {
                            this.showLoading();
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

                colorAxis: {
                    min: 1,
                    max: 1000,
                    type: 'logarithmic',
                },

                series: [
                    {
                        data: [],
                        joinBy: ['iso-a3', 'code3'],
                        name: 'Covid 19 cases',
                        states: {
                            hover: {
                                color: '#a4edba',
                            },
                        },
                        tooltip: {
                            valueSuffix: 'cases',
                        },
                    },
                ],
            },
        };
    },

    async mounted() {
        try {
            await this.fetchDataAllCountries();
        } catch (err) {
            console.table(err);
        }
    },
    methods: {
        ...mapActions('dashboard', ['trackingByContinent', 'allCountries']),
        async fetchDataAllCountries() {
            const response = await this.allCountries();
            const countries = response.data;
            if (!!countries) {
                const seriesData = countries.map((o) => {
                    return {
                        name: _.get(o, 'country'),
                        value: _.get(o, 'cases', 0) < 1 ? 1 : _.get(o, 'cases', 0),
                        code: _.get(o, 'countryInfo.iso2'),
                        code3: _.get(o, 'countryInfo.iso3'),
                    };
                });
                if (!!seriesData) {
                    this.countriesChartOptions.series = {
                        data: seriesData,
                        joinBy: ['iso-a3', 'code3'],
                        name: 'Covid 19 cases',
                        states: {
                            hover: {
                                color: '#a4edba',
                            },
                        },
                        tooltip: {
                            valueSuffix: 'cases',
                        },
                    };
                    this.$refs.countriesChart.chart.hideLoading();
                }
            }
        },
        async fetchApiTracking(continent) {
            this.processing = true;
            try {
                const response = await this.trackingByContinent(continent);
                const {countries, population, cases, deaths, recovered, active, todayCases, todayDeaths, todayRecovered, critical} = response.data;
                this.countries = countries;
                this.population = population;
                this.cases = cases;
                this.deaths = deaths;
                this.recovered = recovered;
                this.active = active;
                this.todayCases = todayCases;
                this.todayDeaths = todayDeaths;
                this.todayRecovered = todayRecovered;
                this.critical = critical;
            } catch (err) {
                console.table(err);
            }
            this.processing = false;
        },
        async handleContinentChange() {
            try {
                await this.fetchApiTracking(this.continent);
            } catch (err) {
                console.table(err);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
