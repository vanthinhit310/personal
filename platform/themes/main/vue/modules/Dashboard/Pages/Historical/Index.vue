<template>
    <div class="chart__wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Covid-19 Historical Data by country</h1>
        </div>
        <a-row :gutter="[30, 30]">
            <a-col :span="24"> Select country you want to show historical</a-col>
        </a-row>
    </div>
</template>

<script>
import {mapActions, mapMutations} from 'vuex';

export default {
   data() {
       return {
           countriesOption: [],
           country : ''
       }
   },
   async mounted () {
       this.fetchCountries();
   },
   methods: {
       ...mapActions('dashboard', ['countries']),
       ...mapMutations({
           setLoadingState : 'dashboard/setLoadingState'
       }),
       async fetchCountries() {
           try {
               const response = await this.countries();
               console.log('====================================');
               console.log(response);
               console.log('====================================');
           } catch (err) {
               console.table(err.message)
           }
       }
   },
};
</script>

<style scoped></style>
