Το project είναι ένα ολοκληρωμένο web application για διαχείριση και ανάλυση επιχειρησιακών δεδομένων (Measurements & KPIs).
Η εφαρμογή επιτρέπει σε χρήστες διαφορετικών εταιρειών να συνδέονται στο σύστημα και να έχουν πρόσβαση αποκλειστικά στα δεδομένα που αντιστοιχούν στην εταιρεία τους.

Στόχος της εφαρμογής είναι η οργάνωση, παρακολούθηση και οπτικοποίηση επιχειρησιακών δεικτών απόδοσης (KPIs) μέσα από ένα φιλικό και δυναμικό περιβάλλον.

 Tech Stack

Το project βασίζεται σε σύγχρονες και αξιόπιστες τεχνολογίες:

Backend: Laravel

Frontend: React

Database: MariaDB

Αρχιτεκτονική

RESTful API με Laravel

Authentication & Authorization

Relational Database Design

Dynamic Data Visualization

Multi-company data isolation

User Roles & Access Logic

Ο κάθε χρήστης συνδέεται μέσω authentication system.

Τα δεδομένα που βλέπει φιλτράρονται βάσει της εταιρείας στην οποία ανήκει.

Υποστηρίζεται απομόνωση δεδομένων (data isolation) ανά εταιρεία.

Δυνατότητα διαχείρισης (CRUD operations) μόνο στα επιτρεπόμενα records.

 Core Features
 Authentication & Company-Based Access

Secure login σύστημα

Company-based filtering

Role-based access logic (επεκτάσιμο)

 KPI & Measurements Management

Ο χρήστης μπορεί να:

Καταχωρεί νέα measurements

Επεξεργάζεται υπάρχοντα δεδομένα

Διαγράφει εγγραφές

Αναζητά & φιλτράρει δεδομένα

Data Visualization

Δυναμικά charts και διαγράμματα

Οπτικοποίηση KPIs

Real-time data updates

Interactive filtering

 Database Structure (High-Level)

Η βάση δεδομένων περιλαμβάνει ενδεικτικά:

Users

Companies

KPIs

Measurements

Relationships μεταξύ χρηστών και εταιρειών

Το schema έχει σχεδιαστεί με έμφαση:

Στην αποδοτικότητα

Στην επεκτασιμότητα

Στην ασφάλεια δεδομένων

 API Design

Το backend λειτουργεί ως REST API και παρέχει endpoints για:

Authentication

CRUD operations για KPIs & Measurements

Company-scoped queries

Aggregated KPI data για charts

 Στόχος του Project

Η εφαρμογή επιλύει το πρόβλημα της αποσπασματικής διαχείρισης επιχειρησιακών μετρήσεων, παρέχοντας:

Κεντρικοποιημένη διαχείριση δεδομένων

Διαχωρισμό δεδομένων ανά εταιρεία

Δυναμική οπτικοποίηση KPIs

Εύκολη επεκτασιμότητα

 Future Improvements

Role management (Admin / Manager / Viewer)

Export δεδομένων (CSV, Excel)

Advanced analytics

Dashboard customization

Notifications & Alerts για KPI thresholds
