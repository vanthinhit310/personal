import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const DashboardRepository = RepositoryFactory.get("dashboard");
export default {
    handleLoading({ dispatch, state, commit }, status) {
        commit("setLoadingState", status);
    },
    async trackingByContinent({ dispatch, state, commit }, continent) {
        return await DashboardRepository.trackingByContinent(continent);
    },
    async allContinents({ dispatch, state, commit }) {
        return await DashboardRepository.allContinents();
    },
    async allCountries({ dispatch, state, commit }) {
        return await DashboardRepository.allCountries();
    },
    async specificCountry({ dispatch, state, commit }, country) {
        return await DashboardRepository.specificCountry(country);
    },
    async countries(){
        return await DashboardRepository.countries();
    }
};
