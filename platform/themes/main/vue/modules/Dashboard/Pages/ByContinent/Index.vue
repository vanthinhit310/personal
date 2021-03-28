<template>
    <div class="chart__wrap">
        <div class="form__group">
            <div class="form__group-label"><span>Select Continent</span></div>
            <div class="form__group-input">
                <el-select @change="handleContinentChange" size="large" v-model="continent" placeholder="Select continent">
                    <el-option v-for="(item, index) in continents" :key="index" :label="item" :value="item"> </el-option>
                </el-select>
            </div>
        </div>
        <div class="chart__wrap--content mt-30">
            <a-spin tip="processing..." :spinning="processing">
                <a-icon slot="indicator" type="sync" style="font-size: 20px" spin />
                <a-row :gutter="[16, 16]">
                    <a-col :span="12">
                        <a-card>
                            <a-statistic title="Countries" :value="countCountries" :precision="0" suffix="countries" :value-style="{color: '#303133'}">
                                <template #prefix>
                                    <a-icon type="global" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                    <a-col :span="12">
                        <a-card>
                            <a-statistic title="Population" :value="population" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#606266'}">
                                <template #prefix>
                                    <a-icon type="solution" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                    <a-col :span="6">
                        <a-card>
                            <a-statistic title="Cases" :value="cases" :precision="0" suffix="people" :value-style="{color: '#E6A23C'}">
                                <template #prefix>
                                    <a-icon type="team" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                    <a-col :span="6">
                        <a-card>
                            <a-statistic title="Deaths" :value="deaths" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#F56C6C'}">
                                <template #prefix>
                                    <a-icon type="frown" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                    <a-col :span="6">
                        <a-card>
                            <a-statistic title="Recovered" :value="recovered" :precision="0" suffix="people" :value-style="{color: '#67C23A'}">
                                <template #prefix>
                                    <a-icon type="heart" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                    <a-col :span="6">
                        <a-card>
                            <a-statistic title="Active" :value="active" :precision="0" suffix="people" class="demo-class" :value-style="{color: '#409EFF'}">
                                <template #prefix>
                                    <a-icon type="medicine-box" />
                                </template>
                            </a-statistic>
                        </a-card>
                    </a-col>
                </a-row>
            </a-spin>
        </div>
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
            processing: false,
        };
    },
    computed: {
        countCountries() {
            return this.countries.length || 0;
        },
    },
    async mounted() {
        try {
            await this.fetchApiTracking(this.continent);
        } catch (err) {
            console.table(err);
        }
    },
    methods: {
        ...mapActions('dashboard', ['trackingByContinent']),
        async fetchApiTracking(continent) {
            this.processing = true;
            try {
                const response = await this.trackingByContinent(continent);
                const {countries, population, cases, deaths, recovered, active} = response.data;
                this.countries = countries;
                this.population = population;
                this.cases = cases;
                this.deaths = deaths;
                this.recovered = recovered;
                this.active = active;
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
