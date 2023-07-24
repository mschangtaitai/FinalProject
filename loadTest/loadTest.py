from locust import HttpUser, between, task


class WebsiteUser(HttpUser):

    def on_start(self):
        data = {"email" : "mschangtaitai@gmail.com", "password" : "password", "device_name" : "locust"}
        response = self.client.post("/sanctum/token", data).json()
        self.token = "Bearer " + response["token"]

    wait_time = between(1, 5)
    
    @task
    def users(self):
        self.client.get("/users")

    @task
    def test(self):
        self.client.post("/test")

    @task
    def currentUser(self):
        self.client.get("/user", headers ={"authorization": self.token})

    @task
    def getItems(self):
        self.client.get("/items", headers ={"authorization": self.token})
    
    @task
    def dashboard(self):
        self.client.get("/dashboard", headers ={"authorization": self.token})
    
    @task
    def finalAvailability(self):
        self.client.get("/final_availability", headers ={"authorization": self.token})

