import requests

url = ""
headers = {
    "Content-Type": "application/x-www-form-urlencoded",
}
payload = "number=100"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=100"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=99"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=101"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=test"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=-1"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
payload = "number=10000000"
response = requests.request("POST", url, data=payload, headers=headers)
print(payload)
print(response.text)
