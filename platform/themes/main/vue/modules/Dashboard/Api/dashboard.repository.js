import axios from "axios";
const instance = axios.create({
    baseURL: "https://corona.lmao.ninja/v2/"
});
export default {
    trackingByContinent(continent) {
        return instance.get(
            `continents/${continent}?yesterday=false&strict=false`
        );
    },
    allContinents() {
        return instance.get(`continents?yesterday=false`);
    }
};
