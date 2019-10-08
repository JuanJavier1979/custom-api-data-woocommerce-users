/**
 * Request data to httpbin
 * 
 * @returns {array} Data from API request
 */
const requestData = async() => {
	// Assign form elements to vars.
	const customDataTextArea = document.getElementById( 'custom_data' );
	const textAreaReturn = document.getElementById( 'custom_return_data' );
	const saveDataButton = document.getElementById( 'save_data_button' );
	const textAreaData = customDataTextArea.value.split( '\n' );

	// Disable some form elements while fetching data.
	customDataTextArea.disabled = true;
	saveDataButton.disabled = true;
	saveDataButton.value = 'Retrieving data...';

	// Fetch data to API.
	const rawResponse = await fetch( 'https://httpbin.org/post', {
		method: 'POST',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: JSON.stringify( textAreaData )
	} );
	const content = await rawResponse.json();

	// Add fetched headers data to text area element.
	textAreaReturn.value = JSON.stringify( content.headers );

	// Enable form elements after fetched data.
	customDataTextArea.disabled = false;
	saveDataButton.disabled = false;
	saveDataButton.value = 'Get data';
};

document.getElementById( 'save_data_button' ).addEventListener( 'click', requestData );