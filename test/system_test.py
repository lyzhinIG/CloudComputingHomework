import requests
import unittest

class YourCodeSystemTest(unittest.TestCase):
    base_url = 'http://app19.test3.net'
    base_number = 400
    n_max = 200001
    headers = {"Content-Type": "application/x-www-form-urlencoded"}

    #успех
    def test_post_request_success(self):
        response = requests.post(self.base_url, data='number='+str(self.base_number+10), headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.text, str(self.base_number+11))
    
    #число уже было
    def test_post_request_number_already_exists(self):
        # первая вставка
        requests.post(self.base_url, data='number='+str(self.base_number+20), headers=self.headers)
        # повторная вставка того же числа
        response = requests.post(self.base_url, data='number='+str(self.base_number+20), headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('the number was already there (число уже было)', response.text)
   
    #число на единицу меньше
    def test_post_request_number_one_less_than_existing(self):
        # первая вставка
        requests.post(self.base_url, data='number='+str(self.base_number+30), headers=self.headers)
        # запрос с числом на 1 меньше
        response = requests.post(self.base_url, data='number='+str(self.base_number+29), headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('current number that is one less than an existing number (число на единицу меньше, чем уже существующее)', response.text)

    #не число на входе
    def test_post_request_not_number_1(self):
        response = requests.post(self.base_url, data='number=abc', headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('The data sent is not a number(прислали не число)', response.text)

    def test_post_request_not_number_2(self):
        response = requests.post(self.base_url, data='number=1a2b3c', headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('The data sent is not a number(прислали не число)', response.text)
    
    #выход за диапазон снизу
    def test_post_request_number_out_of_range_min(self):
        response = requests.post(self.base_url, data='number=-1', headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('The number is not in the required range(число меньше 0 или больше N)', response.text)
    
    #выход за диапазон сверху
    def test_post_request_number_out_of_range_max(self):
        response = requests.post(self.base_url, data='number='+str(self.n_max), headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('The number is not in the required range(число меньше 0 или больше N)', response.text)

    #запрос без нужного поля
    def test_post_not_field(self):
        response = requests.post(self.base_url, data='', headers=self.headers)
        self.assertEqual(response.status_code, 200)
        self.assertIn('Ошибка. Error.  There is no field "number" (нет нужного поля в запросе).', response.text)
    
    #надпись на главной странице при открытии в браузере (GET запрос)
    def test_get_request(self):
        response = requests.get(self.base_url)
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.text, 'Hello world')

if __name__ == '__main__':
    unittest.main()
