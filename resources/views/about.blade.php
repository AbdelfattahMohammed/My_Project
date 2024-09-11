<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Job Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">About Job Board Project</h1>

        <p class="lead">Our Job Board platform connects employers and candidates, facilitating job postings, applications, and hiring processes. The system is designed with different roles and access levels to meet the needs of both job seekers and employers.</p>

        <h2>User Roles and Access</h2>

        <div class="accordion" id="rolesAccordion">
            <!-- Employers Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="employersHeading">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmployers" aria-expanded="true" aria-controls="collapseEmployers">
                        Employers
                    </button>
                </h2>
                <div id="collapseEmployers" class="accordion-collapse collapse show" aria-labelledby="employersHeading" data-bs-parent="#rolesAccordion">
                    <div class="accordion-body">
                        <ul>
                            <li>Register and create an account.</li>
                            <li>Post job listings with detailed descriptions, requirements, and benefits.</li>
                            <li>Edit and manage posted job listings.</li>
                            <li>Review and respond to applications (accept/reject).</li>
                            <li>Access analytics on job postings.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Candidates Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="candidatesHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCandidates" aria-expanded="false" aria-controls="collapseCandidates">
                        Candidates
                    </button>
                </h2>
                <div id="collapseCandidates" class="accordion-collapse collapse" aria-labelledby="candidatesHeading" data-bs-parent="#rolesAccordion">
                    <div class="accordion-body">
                        <ul>
                            <li>Register and create an account.</li>
                            <li>Search for jobs by keywords, location, category, etc.</li>
                            <li>Apply for jobs by submitting resumes or obtaining contact details.</li>
                            <li>Manage profile information and applications (cancel application option).</li>
                            <li>Receive notifications about job applications (bonus feature).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Admins Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="adminsHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                        Admins
                    </button>
                </h2>
                <div id="collapseAdmins" class="accordion-collapse collapse" aria-labelledby="adminsHeading" data-bs-parent="#rolesAccordion">
                    <div class="accordion-body">
                        <ul>
                            <li>Approve or reject job postings submitted by employers.</li>
                            <li>Monitor overall platform activity and user behavior.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-4">Job Listing Management</h2>
        <p>Employers can create detailed job postings that include the following information:</p>
        <ul>
            <li>Job title, description, and responsibilities.</li>
            <li>Required skills and qualifications.</li>
            <li>Salary range and benefits offered.</li>
            <li>Location and work type (remote, on-site, etc.).</li>
            <li>Application deadline.</li>
            <li>Option to upload company logos or branding elements.</li>
        </ul>

        <h2>Application Process</h2>
        <p>Candidates can apply for jobs using multiple methods:</p>
        <ul>
            <li>Uploading their resume directly to the platform.</li>
            <li>Providing contact information such as email and phone number to the employer.</li>
            <li>Filling out application forms within the platform (bonus feature).</li>
        </ul>

        <p>Employers can review applications and contact candidates directly via the platform.</p>

        <h2>Search and Filtering</h2>
        <p>Candidates have the ability to search for jobs based on various criteria such as:</p>
        <ul>
            <li>Keywords in the job title or description.</li>
            <li>Location.</li>
            <li>Job category.</li>
        </ul>

        <!-- Previous Button -->
        <div class="mt-4">
            <button class="btn btn-secondary mb-3" onclick="history.back()">Previous</button>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
