## Дисциплина: Построение распределенных систем и облачные вычисления

### achievement №2
### Команда:
- Еременко Екатерина 
- [Коровин Евгений](https://github.com/EvgeniyKorovin1)
- Лыжин Илья

### Демо

Для проверки работы можно отправить POST запрос на https://homework.iotdatahub.ru/
В переменной `number` должно быть число от 0 до 2147683640 (включительно).
Пример реализации на Python:

```python
import requests

url = "https://homework.iotdatahub.ru"
payload = "number=2147683610"
headers = {
    "Content-Type": "application/x-www-form-urlencoded",
}
response = requests.request("POST", url, data=payload, headers=headers)

print(response.text)
```
