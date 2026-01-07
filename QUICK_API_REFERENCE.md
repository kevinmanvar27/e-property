# 🚀 Quick API Reference - Delete User

## Endpoint
```
POST /api/auth/delete-user
```

## Full URL
```
https://rpropertyhub.com/api/auth/delete-user
```

## Request
```json
{
  "email": "user@example.com",
  "password": "userpassword"
}
```

## Success Response
```json
{
  "success": true,
  "message": "User deleted successfully"
}
```

## Error Responses
- **404** - User not found
- **401** - Invalid password
- **403** - Super admin cannot be deleted
- **422** - Validation error
- **500** - Server error

## cURL Example
```bash
curl -X POST https://rpropertyhub.com/api/auth/delete-user \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"pass123"}'
```

## JavaScript Example
```javascript
const response = await fetch('https://rpropertyhub.com/api/auth/delete-user', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    email: 'user@example.com',
    password: 'pass123'
  })
});
const data = await response.json();
console.log(data);
```

## PHP Example
```php
$ch = curl_init('https://rpropertyhub.com/api/auth/delete-user');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => 'user@example.com',
    'password' => 'pass123'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
```

## Python Example
```python
import requests

response = requests.post(
    'https://rpropertyhub.com/api/auth/delete-user',
    json={
        'email': 'user@example.com',
        'password': 'pass123'
    }
)
data = response.json()
print(data)
```

---

**⚠️ Warning:** This action is irreversible!
