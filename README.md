# company-employee-book
Company-Employee-Book Project

-- Paths To My Project Files --

-- Controller --

./company-employee-book-master/app/Http/Controllers/CompanyController.php

./company-employee-book-master/app/Http/Controllers/EmployeeController.php

./company-employee-book-master/app/Http/Controllers/HomeController.php

-- Models --

./app/Rules/ValidatorCompanyName.php

./app/Rules/ValidatorDate.php

./app/Rules/ValidatorEmail.php

./app/Rules/ValidatorVatNumber.php

./company-employee-book-master/app/Company.php

./company-employee-book-master/app/Company_Employee.php

./company-employee-book-master/app/Converter.php

./company-employee-book-master/app/DataSplitOnPage.php

./company-employee-book-master/app/Employee.php

-- Views/includes --

./company-employee-book-master/resources/views/includes/footer.php

./company-employee-book-master/resources/views/includes/header.php

-- Views --

./company-employee-book-master/resources/views/company/create.php

./company-employee-book-master/resources/views/company/edit.php

./company-employee-book-master/resources/views/company/index.php

./company-employee-book-master/resources/views/company/show.php

./company-employee-book-master/resources/views/employee/create.php

./company-employee-book-master/resources/views/employee/edit.php

./company-employee-book-master/resources/views/employee/index.php

./company-employee-book-master/resources/views/employee/show.php

./company-employee-book-master/resources/views/home.php

./company-employee-book-master/resources/views/welcome.php

-- Route --

./company-employee-book-master/web.php

-- JavaScript --

./js/mc.js

-- CSS --

./css/mc.css

-- Database File Settings --

./company-employee-book-master/.env

  PROJECT REQUIREMENTS
   
1. Create a MySql database containing the following information about companies and employees.

   The company consist of the following details:

   Name
   Description
   VAT number
   Email
   Country
   State
   City
   Address
   Date Created
   All of the employees

   Employee consist of the following details:
   
   Name
   Surname
   Email
   Age
   Gender
   Working Experience (how many years)

   All of the companies the person is working in
   Note that each company may have many employees and each employee may work in many companies.

2. For this structure to be implemented a web form is needed with all of the “CRUD” operations.

   For each company it should be possible to add indefinite amount of employees.
   For each employee it should be possible to add indefinite amount of companies.
   
   With following requirements:

2.1 Every field needs to have appropriate validation (front and backend) based on the database field.

a.  Date field, Email and VAT number must be validated using regular expressions.

b.  Valid VAT formats are (Examples: “AAB1234-W1”  “ACC12345X0”):

1)  Starts with two uppercase alphanumerics,
    followed by B and 4 digits, a special
    symbol, another uppercase alphanumeric
    and an optional trailing digit which can
    be 0,1 or 2. The special symbol can be anything except “\” or “/“.
	
2)  Starts with three uppercase alphanumerics,
    followed by 5 digits, another
    uppercase alphanumeric
    and an optional trailing digit which can be 0,1 or 2.
   
b.3 The form must be OWASP compliant

3. Create a separate page with search options.

   There should be one input field where you can enter name of company or name of employee.
   The search should retrieve and display all of the companies matching the input string and all of the
   employees based on name or surname.
   
   The result should list all of the companies and all of the employees.
   
   For each company you need to display company name + number of employees in it.
   For each employee you need to display first and last name + number of companies he/she is
   working in.
   
   Example:

   Company 1 (4 employees)
   Company 2 (35 employees)
   Company 3 (10 employees)
----------------------------------------------------------------------------------------------------------
   Employee 1 (2 companies)
   Employee 2 (1 company)
   Employee 3 (4 companies)
   Employee 4 (5 companies)
