import axios from "axios";
import qs from "qs";
const instance = axios.create({
    baseURL: "https://disease.sh/v3/covid-19/",
    paramsSerializer: qs.stringify
});
export default {
    trackingByContinent(continent) {
        return instance.get(
            `continents/${encodeURIComponent(continent)}?yesterday=false&strict=false`
        );
    },
    allContinents() {
        return instance.get(`continents?yesterday=false`);
    }
};
