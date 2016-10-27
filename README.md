# TaskBunny

Tasks Web Application Project for CS2102 Group 16

For this group project, our team was assigned to complete a TaskRabbit clone, which we named TaskBunny. In the application, users could add a task to be matched with another user, update their posted task, assign themselves to a task to do, and use search functions to look through the tasks. Admins could edit and delete tasks as well as using regular user functions, as well as having access to some basic statistics. Each task is assigned to a task category, where details such as salary, location, dates, and a description are present. In the backend of the application, we used Apache as the web server, while also using Php and Postgres as the server page language and database management systems, respectively. The frontend was done using HTML, CSS, and JavaScript.


##Group Members:
Martin Yim

Mudit Gupta

Timoté Vaucher

Marshall Chua

Sean Zhang




---
##Screenshots:
![alt home] (https://cloud.githubusercontent.com/assets/6991412/19711985/97b5b814-9b6c-11e6-96f1-d3551d524371.png)
![alt signup] (https://cloud.githubusercontent.com/assets/6991412/19711932/1296867c-9b6c-11e6-8a75-04a0a44ae24f.png)
![alt dashboard] (https://cloud.githubusercontent.com/assets/6991412/19713365/176c75f6-9b78-11e6-89fe-1b70dcd28052.png)
![alt addtask] (https://cloud.githubusercontent.com/assets/6991412/19712051/2688e6ec-9b6d-11e6-996e-4c431b93e552.png)

---
#SQL screenshots:
![checkavailability](https://cloud.githubusercontent.com/assets/8888706/19761526/fe2e5bc6-9c68-11e6-94b6-6f22315f425d.PNG)
The goal of this query is to help checking whether the client is free during a certain time frame, ie no overlapping other tasks. Avoid that we give ubiqutiy to people ^^
![counttask](https://cloud.githubusercontent.com/assets/8888706/19761530/0206965a-9c69-11e6-9d0c-27ba82cb6ed1.PNG)
Count the number of taskers for a given task. To now how many people are helping for a task.
![getavailaibletask](https://cloud.githubusercontent.com/assets/8888706/19761533/0683c14e-9c69-11e6-8917-7946d61b7718.PNG)
Get all the available task that are not created by the user and that he's not already helping for that task.
![upsert](https://cloud.githubusercontent.com/assets/8888706/19761535/06b767e2-9c69-11e6-88aa-c0d5f0fa327d.PNG)
Key query in the login phase as we keep the user logged using tokens, insert or update the token for each user accordingly.

Mudipt should be able to put some more interseting screenshots when he's done with his work.
