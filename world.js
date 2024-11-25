document.addEventListener('DOMContentLoaded', () => {
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');
    
    const handleLookup = (lookupType) => {
        const country = countryInput.value.trim();
        fetch(`world.php?country=${encodeURIComponent(country)}&lookup=${lookupType}`)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = `<p>Error fetching data: ${error.message}</p>`;
            });
    };

    document.getElementById('lookup').addEventListener('click', () => handleLookup('countries'));
    document.getElementById('lookup-cities').addEventListener('click', () => handleLookup('cities'));
});
