
import 'whatwg-fetch';



/*
 * Handle all posts to the API.
 * @param form - A form object retrieved from the document.
 * @param token - JWT token retrieved from localstorage
 * @param route - API Route (url) to use
 * @return response - A pre-formatted JSON object
 * {status : 200, content: {}}
 */
let API_POST = (form, token, route) => {
    fetch(route, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        body: new FormData(form),
    }).then(function(response) {
        return response.json();
    }).then(function(response) {
        console.log(response);
        return response;
    })
};
export default API_POST;

