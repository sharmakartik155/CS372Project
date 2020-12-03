# OutlineR

## CS 372 Project

An online outlining software that allows users view the document and see changes as they are made.

## Internal documentation disclaimer

We were not aware until 10:37pm on December 2nd of the need to submit internal documentation with the project.
We will submit our internal documentation with the project report as we originally planned.


## All code is hosted at https://github.com/sharmakartik155/CS372Project.


## Instructions to replicate set-up (external documentation)

1. These instructions are for use with a University of Regina Undergraduate Hercules Account

2. Download the latest "public_html.zip" from the Github repository

3. Unzip and move the folder "public_html" to the root of your hercules account. Its path should be "~/public_html".

4. Set all folder permissions (recursively) to 711, and all file permissions to 644. Use the following hercules commands to do this:

5. Set the folder permission of "~/public_html/users/" to 777. This folder is used for user uploads, and the following file types are permitted for upload: jpg, png, jpeg, gif.

6. Download the file "db.sql" from the github repository, and move it to your home directory.

7. Open your MySQL management command-line from your home directory. Import the create table commands by typing `source db.sql;`.

8. Open the file "~/public_html/snippets/open_db.php". Change the username and password to your own database's credentials.

9. Thouroughly test the website online to ensure that you did everything correctly. If you find a bug in the code, please submit an issue log!

10. Have fun and stay organized during the Pandemic!

## Our story

When we set out to create a real-time Outliner at the start of this project we knew that it was an ambitious goal. We also knew that there would be ways to adjust the scope of the project as we went depending on the difficulties encountered and looming project deadline. By negotiating with our 'user' to validate what their most important requirements were to be complete by the project deadline, we were able to streamline our first iteration of the product and postpone some important features for version 2 while still delivering a working product. But to learn more about that, you will have to wait for the report!

The most important thing that we had to learn from was how difficult it is to collaborate on code. Even with the abundance of tools we had freely at our disposal, we spent the first 6 weeks to realize that we were spending far more time trying to collaborate on writing the code than we were spending on the project itself. Additionally, we didn't learn about many of the tools and techniques available in Software Engineering until we had less than a month left to complete our project: which is when we had originally planned on being done with the code and exclusively in the test phase. The saying rings true: "fail to plan, and plan to fail"

Now that we have the class knowledge and experience we have learned from this project, there are a few things that we would do differenly next time. To start, we would more clearly write our plan around milestones that include tangible 'artifacts of completion' such as a formal requirements specification or design specification. We used many tools along the way including a wireframing prototype, but they were used too late an too much knowledge was stuck inside of team members' heads and not on paper. 

Using an iterative waterfall with prototype is what we did in the end, however our process now approaches the circular model as we return to some of the original features that were dropped as we ran out of time. To continue in development in version 2.0, the most important features to implement are the Outliner (which requires some well-tested recursive functions to implement the tree hierarchy) and asynchronous updating of user settings and document access. We decided not to use any of the existing libraries that exist to enable real-time collaboration as we wanted to use the Hercules Web Server, but a future release of this product would probably go back to producing a real-time collaborative outliner rather than a 'lock-to-edit' Outliner.

All together, this was a good project to teach us about how working in teams on complex projects is very difficult, and I only hope that somebody can eventually teach us how to make working in teams easier.

Until then: all the best,

Team Leader: Philip Ottenbreit
