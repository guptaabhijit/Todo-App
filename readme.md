## Tech Spec

Product: Todo App

Todo App is the simple Note Reminder which comes handy for the user.

Features:
1) User should able to Upload and add todo item in the list
2) User should able to fetch all todo items
3) User should able to retrieve specific todo item based on key parameter (Here - Id)
4) User should able to delete todo Item
5) User should edit todo item

Following Signature APIs :

API | Signature |
--- | --- | 
POST | /todos 
GET |  /todos
GET |  /todos/{todo}
DELETE |  /todos/{todo}
PUT  |			/todos
PUT	 |		/todos/status/{todo} (Created,Pending,OnGoing,Done)	
GET	 |		/todos/status?status=created
GET	 | 		/todos/group => get all groups
POST  |			/todos/group  => create new Group
DELETE  |		/todos/group/{id} => delete group along with all todos
GET  |			/todos/group/{id}    ⇒ GET all todo items in ID group


State Transition of STATUS:- 




HTTP Status and Message Handling:-

Status Code | Http Message |
--- | --- | 
200  |  OK (Success)
201  |  Created
400  |  Bad Request
404 |  Not Found
403  |  Forbidden


