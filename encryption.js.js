// Using CryptoJS for AES encryption
function encryptData(data, secretKey) {
    return CryptoJS.AES.encrypt(JSON.stringify(data), secretKey).toString();
}

function decryptData(encryptedData, secretKey) {
    const bytes = CryptoJS.AES.decrypt(encryptedData, secretKey);
    return JSON.parse(bytes.toString(CryptoJS.enc.Utf8));
}

// Example usage in booking form
document.getElementById('booking-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const secretKey = 'server-provided-key'; // In production, get this from server session
    const guestData = {
        name: document.getElementById('name').value,
        contact: document.getElementById('contact').value,
        specialRequests: document.getElementById('requests').value
    };
    
    document.getElementById('encrypted-data').value = encryptData(guestData, secretKey);
    this.submit();
});