# Project
Topic B: Crowdfunding

# Todo

BackEnd
1. Logout function (done)
2. User can change their password
3. Search for project function
4. Project page functions

FrontEnd
1. Implement proper browse function
2. Project Page
3. Search function


#Grading
The following is the breakdown of the project grading scheme.
• Pre-alpha demonstration: 1 mark

• Alpha demonstration: 1 mark

• Report & Final Demonstration: 12 marks
	– Database design: ER and DDL (3 marks)
	– SQL DML code (2 marks)
	– Implementation of non-trivial integrity constraint (2 marks)
	– Usage of advanced SQL features (2 marks)
	– Application design, functionalities, and interface (3 marks)
	
• The top-10 projects will each receive 1 additional mark

## Users
- New users have joined date = current date
- Users should have billing address (?)
- Creating new account success should give a prompt (e.g register successful)
- **Create account status (banned or not banned)**

## UAC
- User can change password
- Password constraints (minimum of 8 characters)

## Projects (entrepreneurs)
- **User can view and edit their own projects (Edit contraints e.g cannot edit end date earlier than current date))**
- User can delete and stop their project (need to refund all investors) 
- User can select a pre-defined set of categories
- Users can view their past completed projects
- Users can extend deadlines

## Projects (Investors)
- Investors can keep track of all the projects that they have invested in
- Investors can check how much they have invested thus far
- Fake credit card payment page when paying
- Investors can check investment history

## Admin
- Admin can edit ALL projects (Edit contraints)
- Admin can remove ALL projects	
- Admin can edit other users (even make them admin or remove admin)
- Admin can remove other users (deletion must keep key integrity in place)

## Projects
- **Creating projects need to have an image**
- Can select individual projects to display on a page
- Created projects have default start date = current date
- Creating projects will direct users back to home page
- **Add project status to DB(waiting to start, started, finished, halted, stopped)**


## No user
- advertises successfully funded projects on a webpage


## Search
- Search by project description
- Search by project title
- Search by category
- Advanced Search 

## Advanced Features
- Progress bar to show the progress towards the fund needed to be raised


