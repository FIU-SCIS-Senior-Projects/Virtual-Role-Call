/* global app */

app.factory('DataRequest', function ($http, $q) {

    return{
        login: function (username, password) {

            function promiseExecutor(resolve, reject) {
                $http.post("php/login.php", {"username": username,
                    "password": password})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        },
        register: function (lastName, firstName, username, encryptedPass, userType, userShift) {

            function promiseExecutor(resolve, reject) {
                $http.post("register.php", {
                    "lastName": lastName,
                    "firstName": firstName,
                    "username": username,
                    "password": encryptedPass,
                    "userType": userType,
                    "userShift": userShift})
                        .then(function (data) {
                            resolve(data.data);
                        }, function (error) {
                            reject(error);
                        });
            }
            return $q(promiseExecutor); // this function will determine when the function is finished.
        }
    };
});


//    var me = this;

//    me.parseResponse = function (result) {
//        //if the response is not a string it means that it has been interpreted as a javascript object already
//        if (typeof result.data === 'string') {//if response is a string
//            var jsonResponse;
//            try {
//                jsonResponse = JSON.parse(result.data);//try to parse the string into a javascript object (json)
//            } catch (err) {//if could not parse the string
//                console.log("invalid json response:");//the server gave us something unexpected
//                console.log(result.data + "\n");//log the data
//                jsonResponse = false;//specify invalid server response
//            }
////            console.log(jsonResponse);
//            return jsonResponse;
//        }
////        console.log(result.data);
//        return result.data;
//    };

//    makeRequest = function (url, params) {
//        return $http.post(url, params)//Make request
//                .then(function (result) {//Server response in the result variable
//
//                    console.log("priting result");
//                    console.log(result);
//                    return me.parseResponse(result);//parse the response into javascript
//                });
//    };