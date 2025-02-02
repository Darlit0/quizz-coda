export const login = async (username, password) => {
    const formData = new URLSearchParams();
    formData.append('username', username);
    formData.append('password', password);

    console.log('Sending login request with:', { username, password }); // Debug message

    const response = await fetch('../controller/login.php', {
        method: 'POST',
        body: formData
    });

    const text = await response.text(); // Get the raw response text
    console.log('Received raw response:', text); // Debug message

    try {
        const result = JSON.parse(text); // Parse the JSON
        console.log('Parsed response:', result); // Debug message
        return result;
    } catch (error) {
        console.error('Error parsing JSON:', error);
        return { errors: ['Invalid server response', text] }; // Include raw response in error
    }
}