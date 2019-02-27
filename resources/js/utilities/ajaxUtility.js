export default {

    requestType: {
        GET: 'GET',
        POST: 'POST',
        PUT: 'PUT',
        DELETE: 'DELETE'
    },

    sendRequest: function(url, data, requestType, beforeSendCallBack, successCallBack, errorCallBack, headers, generateCancelToken) {
        "use strict";

        let axios = window.axios,
            axiosRequest,
            options = {},
            cancelTokenSource = null;

        beforeSendCallBack();

        url = url.replace(/#/g, "");

        if(headers) {
            options.headers = headers;
        }

        if(generateCancelToken) {
            const CancelToken = axios.CancelToken;
            cancelTokenSource = CancelToken.source();

            options.cancelToken = cancelTokenSource.token;
        }

        switch (requestType) {
            case this.requestType.GET:
                let finalUrl = url;

                if(undefined !== data && "" !== data) {
                    finalUrl += "?"+data;
                }

                axiosRequest = axios.get(
                    finalUrl,
                    options
                );
                break;
            case this.requestType.POST:
                axiosRequest = axios.post(
                    url,
                    data,
                    options
                );
                break;
            case this.requestType.PUT:
                axiosRequest = axios.put(
                    url,
                    data,
                    options
                );
                break;
            case this.requestType.DELETE:
                axiosRequest = axios.delete(
                    url,
                    {
                        params: data
                    },
                    options
                );
                break;
        }

        axiosRequest
        .then(
            function (response) {
                successCallBack(response);
            }
        ).catch(
            function (error) {
                if (axios.isCancel(error)) {
                    console.log('Request canceled', error.message);
                } else {
                    if(typeof (error.response.status !== undefined)) {
                        switch (error.response.status) {
                            case window.utilities.statusCodeUtility.HTTP_FORBIDDEN:
                                window.alertify.error('You are forbidden to perform this action.');
                                break;
                            case window.utilities.statusCodeUtility.UNAUTHORIZED:
                                setTimeout(function(){ window.location.reload();}, 2000);
                                window.alertify.error('You are not authenticated.');
                                break;
                        }
                    }
                }
                errorCallBack(error);
            }
        );

        return cancelTokenSource;
    }

};
