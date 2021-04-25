import axiosClient from "@core/apis/axiosClient.js";

import axios from "axios";
import qs from "qs";

const googlePhoto = axios.create({
    baseURL: "https://photoslibrary.googleapis.com/",
    paramsSerializer: qs.stringify
});

export default {
    getMediaItems(accessToken, pageToken = null) {
        let params
        if (!!pageToken) {
            params = {
                access_token: accessToken,
                pageToken: pageToken
            }
        } else {
            params = {
                access_token: accessToken,
            }
        }

        return googlePhoto.get(`v1/mediaItems`, {
            params: params
        });
    }
};
