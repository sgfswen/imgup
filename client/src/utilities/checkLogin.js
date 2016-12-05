/**
 * Created by nef on 12/2/16.
 */
import jwt_decode from 'jwt-decode';


let CheckLogin = function(){
    let user = {};
    // Check if there is a jwt value in local storage
    if (localStorage.getItem("jwt")){
        let encoded = JSON.parse(localStorage.getItem("jwt")).jwt;
        let decoded = jwt_decode(encoded);
        if (decoded){
            user = {
                authenticated:true,
                userName: decoded.data.userName,
                userId: decoded.data.userId,
                isAdmin: parseInt(decoded.data.admin),
                encoded: encoded
            };
        return user;
        }
    } else {
        return false;
    }
};

export default CheckLogin;