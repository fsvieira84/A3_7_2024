document.addEventListener('DOMContentLoaded', () => {
    fetchJobs();
});

async function fetchJobs() {
    const apiUrl = 'https://api.adzuna.com/v1/api/jobs/us/search/1';
    const params = new URLSearchParams({
        app_id: 'b54b224d',  // Substitua pelo seu App ID
        app_key: '3d04a0f589e173d2ffabb30c007928ad',  // Substitua pela sua App Key
        results_per_page: 10,
        what: 'developer',
        where: 'remote'
    });

    try {
        const response = await fetch(`${apiUrl}?${params}`);
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        const data = await response.json();
        displayJobs(data.results);
    } catch (error) {
        console.error('Failed to fetch jobs:', error);
    }
}

function displayJobs(jobs) {
    const jobList = document.getElementById('job-list');
    jobList.innerHTML = '';

    jobs.forEach(job => {
        const jobElement = document.createElement('div');
        jobElement.className = 'job';

        jobElement.innerHTML = `
            <h2 class="job-title">${job.title}</h2>
            <p class="job-company">${job.company.display_name}</p>
            <p>${job.location.display_name}</p>
            <a href="${job.redirect_url}" target="_blank">Mais detalhes</a>
        `;

        jobList.appendChild(jobElement);
    });
}
