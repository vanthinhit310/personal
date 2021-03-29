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
            <a-col :span="24">
                <div class="form__group">
                    <div class="form__group-label"><span>Specific Country</span></div>
                    <div class="form__group-input">
                        <el-select @change="handleContinentChange" size="large" v-model="continent" placeholder="Select continent">
                            <el-option v-for="(item, index) in continents" :key="index" :label="item" :value="item"> </el-option>
                        </el-select>
                    </div>
                </div>
            </a-col>
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
            continent: 'Asia',
            continents: ['North America', 'South America', 'Asia', 'Europe', 'Africa', 'Australia/Oceania'],
            countries: [],
            population: 0,
            cases: 0,
            deaths: 0,
            recovered: 0,
            active: 0,
            todayCases: 0,
            todayDeaths: 0,
            todayRecovered: 0,
            critical: 0,
            processing: false,

            countriesChartOptions: {
                chart: {
                    type: 'packedbubble',
                    height: '500px',
                },
                title: {
                    text: 'Case covid 19 for all countries all over the world!',
                },
                tooltip: {
                    useHTML: true,
                    pointFormat: '<b>{point.name}:</b> {point.value} cases',
                },
                plotOptions: {
                    packedbubble: {
                        minSize: '10%',
                        maxSize: '150%',
                        zMin: 0,
                        zMax: 100000,
                        layoutAlgorithm: {
                            splitSeries: false,
                            gravitationalConstant: 0.02,
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}',
                            filter: {
                                property: 'y',
                                operator: '>',
                                value: 250,
                            },
                            style: {
                                color: 'black',
                                textOutline: 'none',
                                fontWeight: 'normal',
                            },
                        },
                    },
                },
                series: [
                    {
                        name: 'Europe',
                        data: [],
                    },
                    {
                        name: 'Africa',
                        data: [],
                    },
                    {
                        name: 'Australia/Oceania',
                        data: [],
                    },
                    {
                        name: 'North America',
                        data: [],
                    },
                    {
                        name: 'South America',
                        data: [],
                    },
                    {
                        name: 'Asia',
                        data: [],
                    },
                ],
            },
        };
    },
    computed: {
        countCountries() {
            return this.countries.length || 0;
        },
    },
    async mounted() {
        try {
            await this.fetchDataAllCountries();
            // await this.fetchApiTracking(this.continent);
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
                const asia = {
                    name: 'Asia',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'Asia') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const europe = {
                    name: 'Europe',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'Europe') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const northAmerica = {
                    name: 'North America',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'North America') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const africa = {
                    name: 'Africa',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'Africa') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const southAmerica = {
                    name: 'South America',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'South America') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const australiaOceania = {
                    name: 'Australia/Oceania',
                    data: countries
                        .map((o) => {
                            if (o.continent == 'Australia/Oceania') {
                                return {
                                    name: _.get(o, 'country'),
                                    value: _.get(o, 'cases', 0),
                                };
                            }
                        })
                        .filter((notUndefined) => notUndefined !== undefined),
                };
                const series = [asia, europe, northAmerica, southAmerica, africa, australiaOceania];
                if (!!series) {
                    this.countriesChartOptions.series = series;
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
