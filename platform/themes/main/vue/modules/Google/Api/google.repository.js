import axios from "axios";
import qs from "qs";

const googlePhoto = axios.create({
    baseURL: "https://photoslibrary.googleapis.com/",
    paramsSerializer: qs.stringify
});

export default {
    getMediaItems(accessToken, pageToken = null) {
        let params = { access_token: accessToken };

        if (!!pageToken) {
            params = { ...params, pageToken: pageToken };
        }
        return googlePhoto.get(`v1/mediaItems`, {
            params: params
        });
    },
    filterMediaItems(accessToken, pageToken = null, filter = null) {
        let params = {};
        if (!!filter) {
            const startDate = filter[0];
            const endDate = filter[1];
            const startDateParams = _.split(startDate, "/");
            const endDateParams = _.split(endDate, "/");
            params = {
                ...params,
                filters: {
                    dateFilter: {
                        ranges: [
                            {
                                startDate: {
                                    year: startDateParams[2],
                                    month: startDateParams[1],
                                    day: startDateParams[0]
                                },
                                endDate: {
                                    year: endDateParams[2],
                                    month: endDateParams[1],
                                    day: endDateParams[0]
                                }
                            }
                        ]
                    }
                }
            };
        }

        if (!!pageToken) {
            params = { ...params, pageToken: pageToken };
        }
        console.log(`params`, params);
        return googlePhoto.post(`v1/mediaItems:search`, params, {
            headers: {
                Authorization: "Bearer " + accessToken
            }
        });
    }
};
