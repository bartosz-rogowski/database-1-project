# Project for Databases 1
PostgreSQL database with simple GUI aiming to help tracking patients' health state, basic information and reporting number of cases, deaths and recoveries for every voivodeship in Poland [project for "Databases 1"].

Web application with database (on faculty's server) enables users to log in for 4 possible kinds of accounts:
* Person/Patient
  - can display personal information (including people who consented to provide them those info.)
  - can change their password
  - can update their contact details
  - can sign up for a covid test 
* Doctor
  - can change patient's health state 
  - can change their password
  - can impose quarantine for person
* Laboratory worker
  - can enter test positivity
  - can change their password
* Worker of voivodeship headquarters of sanepid (sanitary-epidemiological station)
  - can display reports for one voivodeship or entire country (statistics only, without personal data) of:
    - new cases (for one day, 30 days or all history)
    - new deaths
    - new recoveries
  - can impose isolation for person
  - can change the password
  - can search for a person or people with given data (personal ID number, first name, last name or any combination of these)
