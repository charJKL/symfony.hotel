import {API_URL_HOST} from '/js/config.js';

document.addEventListener("DOMContentLoaded", function(event) 
{
	console.log("js/main/homepage.js");
	
	console.log(parseFloat("351.45"));
	
	const headers = new Headers();
			headers.set('Accept', 'application/json');
	const request = fetch(API_URL_HOST + '/api/rooms', {method: 'GET', headers});
	const response = request.then(onResponse).then(onData);
});

function onResponse(response)
{
	console.log(response);
	return response.json();
}

function onData(data)
{
	console.log(data);
}
