export const login = async (username, password) => {
    const formData = new URLSearchParams();
    formData.append('username', username);
    formData.append('password', password);

    console.log('Sending login request with:', { username, password });
    const response = await fetch('../controller/login.php', {
        method: 'POST',
        body: formData
    });

    const text = await response.text();
    console.log('Received raw response:', text);

    try {
        const result = JSON.parse(text);
        console.log('Parsed response:', result);
        return result;
    } catch (error) {
        console.error('Error parsing JSON:', error);
        return { errors: ['Invalid server response', text] };
    }
}