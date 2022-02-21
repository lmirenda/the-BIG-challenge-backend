# The BIG Challenge

## Front-End

NuxtJs

## Back-End

Laravel

## App-Flow

-   Patient fills form with personal information and symptoms
-   On their home screen, doctors have a panel that displays every patient (One submission = one occurrence. one patient can have multiple occurrences) waiting to be checked
-   Doctors can choose which submission to view next, once a submission is taken by a doctor it is erased from the public pool but it stays on the doctor's private history (task history)
-   For each submission, when clicked, a detail view is displayed. This view has to show the information from the submission (including patient data) and has to allow the doctor to submit a diagnosis (prescription) in the form of a file upload.
    Simulation (txt file)
-   The patient is notified with an email that a prescription was issued for his submission
-   The patients needs to be able to see the submissions filtered by "not taken by any doctor yet (pending)", "taken by a doctor but not yet resolved (in progress)", "with prescriptions (done/ready)"
-   If a submission has a doctor or doctors assigned, this information has to be displayed on the submission detail view. (Patient and doctor)
    On the patient's submission detail view, the patient has to see the symptoms and the doctors assigned to that submission
-   If the submission is resolved, a "download" button has to download the prescription when clicked. (Prescription download link has to expire, after the expiration time is up, the link is no longer valid. The link is generated when the patient enters the detail view)
