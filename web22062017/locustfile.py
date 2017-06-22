from locust import HttpLocust, TaskSet

def login(l):
    l.client.post("/login.php", {"username":"vitor", "password":"vitor"})


class UserBehavior(TaskSet):
    #tasks = {index: 2, profile: 1}

    def on_start(self):
        login(self)

class WebsiteUser(HttpLocust):
    task_set = UserBehavior
    min_wait = 5000
    max_wait = 9000