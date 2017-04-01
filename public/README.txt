¦¦¦¦¦¦¦¦_   _¦     _¦¦¦¦¦¦_   _¦     _¦¦¦¦¦¦¦_  _¦¦¦¦¦¦_   _¦  ¦¦¦____       ¦¦¦          
¦¦¦   ¯¦¦¦ ¦¦¦    ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦ ¦¦¦  ¦¦¦¯¯¯¦¦_ ¯¦¦¦¦¦¦¦¦¦_      
¦¦¦    ¦¦¦ ¦¦¦¦   ¦¦¦    ¦¯  ¦¦¦¦   ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦ ¦¦¦¦ ¦¦¦   ¦¦¦    ¯¦¦¦¯¯¦¦      
¦¦¦    ¦¦¦ ¦¦¦¦  _¦¦¦        ¦¦¦¦   ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦ ¦¦¦¦ ¦¦¦   ¦¦¦     ¦¦¦   ¯      
¦¦¦    ¦¦¦ ¦¦¦¦ ¯¯¦¦¦ ¦¦¦¦_  ¦¦¦¦ ¯¦¦¦¦¦¦¦¦¦¯  ¦¦¦    ¦¦¦ ¦¦¦¦ ¦¦¦   ¦¦¦     ¦¦¦          
¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦        ¦¦¦    ¦¦¦ ¦¦¦  ¦¦¦   ¦¦¦     ¦¦¦          
¦¦¦   _¦¦¦ ¦¦¦    ¦¦¦    ¦¦¦ ¦¦¦    ¦¦¦        ¦¦¦    ¦¦¦ ¦¦¦  ¦¦¦   ¦¦¦     ¦¦¦          
¦¦¦¦¦¦¦¦¯  ¦¯     ¦¦¦¦¦¦¦¦¯  ¦¯    _¦¦¦¦¯       ¯¦¦¦¦¦¦¯  ¦¯    ¯¦   ¦¯     _¦¦¦¦¯        
                                                                                                          
Author - Rasheed Andrews  
Contact - rasheed_andrews@live.com
Date - July 29,2016
Description - This project is a RAAS(Registration As A Service) website that provides different
	      tools which developers can use to authenticate and register user accounts such as standard
	      registration with an ID and password, social login or sms login, an API is also availble 
	      which provides additional features. 
-----------------------------
Software used in this project
-----------------------------
Atom(v1.8.0) - Text Editor
Postman(v4.4.3) - Rest Client(Allows for testing of routes using HTTP methods)   
phpPgAdmin(v5.1) - web-based administration tool for PostgreSQL 
WinSCP(v5.7.7) - FTP Client used to store project files
Google Chrome(v52.0.2743.82 m) - Main Web browser used to develop and test website
Microsoft Excel 2013 - Documenting all files used in this project
PostgreSQL Maestro(v16.6) - Generate Database schema diagram for documentation
Diagram Designer(v1.26) - Creation of High Level diagrams showing data flow and logic
------------------------------------
Languages,Frameworks and APIs used
------------------------------------
* CSS - Website styling
* HTML - Website layout
* JavaScript- Client side functionality
* JQuery(v2.1.1) - DOM Manipulation
* Ajax(v2.1.1-bundled with JQuery Library) - Interaction between JavaScript and PHP
* PHP(v5.6.6) - Server side functionality(Database interation or HTTP Request)
* Slim(v3.1) - PHP framework for creating API 
* PostgresSQL(v9.3.13) - Database
* MaterializeCSS(v0.97.6) - UI Framework
* d3.js(v3) - Creation of charts for analytics
* d3-tip(v0.6.3) - Add tool tip to Bar chart
* Pikaday(v1.4.0) - Calendar to select date from 
* Moment.js(v2.10.3) - Date formating when selecting from Calendar
* Facebook Login for the Web with the JavaScript SDK(v2.5) - Facebook social login
* Authentication using the Google APIs Client Library for JavaScript(v2) - Google social login
* Sign In with LinkedIn using the JavaScript SDK(v1) - Linkedin social login 
* Instagram Authentication Server-side flow(v1) - Instagram social login
* digiutil sms - send SMS
---------------------------------------------------------------------------------------
Configuration(Getting Started) - NB : This information was written on July 29, 2016
---------------------------------------------------------------------------------------
* Server Address : 192.168.0.2
1. Website Console -  No configuration is needed to get the website running
	-Where to find the website project directory after signing into WinSCP?
		Path : /usr/local/www/apache24/data/api-console 
2. API(php slim) 
	-No configuration is needed as the php slim libray is already installed in the directory. If it hasn't been configured on the server as yet, then you can run it locally using the command php -S localhost:8080

3. LoginHub
     *Social Sandbox
	-No configuration is needed, however you must first create a project/app
	-Before registering for any social authentication service you must first go to the social network's developer website and create a project/app
	-After doing so you will be given a key that allows you to use their service, when creating the project/app they will ask for an authorized origin(sometimes not required)
	 and a authorized redirect URI(Required), please use the URL the LoginHub is currently hosted on. For example, during development I used http://localhost:8181/ as my authorized URI as they will not
	 work with ip addresses such as 192.168.0.2 which is that of the server so I had to run it on my local machine and use localhost but when this service is launched and it is hosted on a domain,
         that domain address should be used instead of localhost. Another thing to note is that when specifying the authorized URI on Facebook,Google and Linkedin you can just use the domain instead of a specific page,
	 meaning you can use http://localhost:8181/ instead of http://localhost:8181/testpage.html , however all those social network is done using client side validation, Instagram on the other hand uses Server Side
	 validation so you must explicitly state which page it must redirect to, in my example it was http://localhost:8181/LoginHub/social-sandbox/db_Instagram.php so keep that in mind, for the rest I just used http://localhost:8181/
	 for both authorized origin and redirect URI.

     *SMS Sandbox
	-The SMS sandbox does not require any configuration

NOTE!!!: Both sms and socail login will NOT WORK on the server (192.168.0.2) until php slim is configured on it. 
	 In order for the user to get access to the service the token must first be sent to the loginhub.php page(this is the brain of the LoginHub) it will then send that token to the API and check if it is valid and 
	 authorized to use the particular service. During development I was running the php slim server on my local machine since it was not configured on the server, so if you want to get the sms and social login working
	 without php slim on the server then you must run it locally. 

	What to do?
	This is not the ideal setup to be working with but due to constraints in place you will have to work around them - here is how, install wampserver on your machine, place the LoginHub folder in your www directory,
	Copy the api folder to your machine(anywhere-probably not your www folder - may conflict with apache server running), then do the following outside of the folder (that is if you copied the api 
	folder to your Desktop then do the following on your Desktop),hold down Shift key then right click, select Open command window here, then enter this command to start the server, 
	php -S localhost:8080 (You must install PHP to run this command)
	You can now use the LoginHub and api in your local environment
---------------------------------------------------------------------
How to use - NB : This information was written on July 29, 2016
---------------------------------------------------------------------
1. Website Console(How to Use/ How it works) -
     *Getting Started:(This information can also be found in "get started - aquire a token.jpg" which shows how to get started in a diagram format)
	-Website can be accessed from this address : http://192.168.0.2/api-console/index.html
	-You must first create a developer account before being able to login
	-After signing in, in order to register for an Authentication service you must first add a project, click the red FAB(Floating Action Button) with the plus sign to do so
	-Click Enable under the Authentication Card, select the authentication options you want
	-If you selected Email registration or SMS, the next page will have a list of default fields which you can rename by selecting the pencil icon, when done renaming click the tick icon to save
	-You can also edit the attributes of the field by selecting the square icon beside the pencil, a dropdown will appear where you can select if the field is required,type and length
	-You can also select up to 12 custom fields if you need more fields, these can also be renamed
	-If the user selected any of the social login they must provide an API key for the project they created on the given social network as well as a redirect url where we can direct to after processing.
	-After clicking the done button a modal box will pop up asking you to select the project you want to assign the authentication service to, select a project ID from the dropdown and click Done
	-The next page will generate sample HTML code that has all the field selections made by the developer, as well as their token embedded in each social link which will allow them to use the social API.
	-The sample code will be in the text area, you can copy this and paste it into your website and it will look exactly as how the demo looks on the page. 
     *More:
	-After registering for an authentication service you will be given a token to use in your project
	-You can go to the projects tab to see the list of projects you have created
	-You can go to the API Keys tab to see all your tokens
	-The analytics tab provides different statistics based on user activies such as sign ups and daily usage. Two charts are provided : Calendar and Bar Chart.
	-The Calendar chart can show the total signs ups annually, total daily users annually, these can also be narrowed down to a specific region.
	-The Bar chart can show a region by region comparison for total sign ups as well as total daily users within a date range specified.
	-To do a query you must select a project using the dropdown, if its a bar chart query then you must click in the text box and select a start and end date	

2. LoginHub
    *Social Sandbox 
	-If the user wants to use social service, they must provide their token that they received when registering for the service, an option which can be either login or logout, a type which must 
	 be anyone of the available social service such as facebook,google,instagram or linkedin and a redirect url that we must return the response to. 
	 All this information must be sent to the loginhub.php page in a get request - the example in the sample uses an anchor tag to make the transfer to the page along with the requested information.
	-If the user is logging out of a socail service they must provide the same infomation with option being logout and an ID so we know which user to log out.

    *SMS Sandbox
	-This works the same just as the social sandbox, the only difference is that the type is sms. 

NOTE: A code sample of how to interact with the sms and social login is stored in the sample folder

3. API	
	-The token must be placed in the header of the request, any other information must be in the body of the request
	-All the routes available are listed in the excel file API-Console DOCS and all the methods are HTTP POST

