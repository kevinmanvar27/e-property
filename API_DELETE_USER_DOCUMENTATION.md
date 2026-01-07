# Delete User API Documentation

## Endpoint
**POST** `/api/auth/delete-user`

## Description
This API endpoint allows you to delete a user account by providing valid email and password credentials. The user must authenticate with their password to confirm the deletion.

## Request

### Headers
```
Content-Type: application/json
Accept: application/json
```

### Body Parameters
| Parameter | Type   | Required | Description                          |
|-----------|--------|----------|--------------------------------------|
| email     | string | Yes      | The email address of the user        |
| password  | string | Yes      | The password of the user to verify   |

### Example Request (cURL)
```bash
curl -X POST https://rpropertyhub.com/api/auth/delete-user \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "userpassword123"
  }'
```

### Example Request (JavaScript/Fetch)
```javascript
fetch('https://rpropertyhub.com/api/auth/delete-user', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    email: 'user@example.com',
    password: 'userpassword123'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### Example Request (Postman)
1. Set method to **POST**
2. URL: `https://rpropertyhub.com/api/auth/delete-user`
3. Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
4. Body (raw JSON):
```json
{
  "email": "user@example.com",
  "password": "userpassword123"
}
```

## Response

### Success Response (200 OK)
```json
{
  "success": true,
  "message": "User 'John Doe' (user@example.com) has been deleted successfully.",
  "data": {
    "deleted_user": {
      "id": 123,
      "name": "John Doe",
      "email": "user@example.com"
    }
  }
}
```

### Error Responses

#### Validation Error (422 Unprocessable Entity)
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

#### User Not Found (404 Not Found)
```json
{
  "success": false,
  "message": "User not found with the provided email."
}
```

#### Invalid Password (401 Unauthorized)
```json
{
  "success": false,
  "message": "Invalid password. User deletion failed."
}
```

#### Super Admin Protection (403 Forbidden)
```json
{
  "success": false,
  "message": "Super admin users cannot be deleted."
}
```

#### Server Error (500 Internal Server Error)
```json
{
  "success": false,
  "message": "An error occurred while deleting the user. Please try again.",
  "error": "Detailed error message (only in debug mode)"
}
```

## Security Features
1. **Password Verification**: User must provide correct password to delete account
2. **Super Admin Protection**: Super admin accounts cannot be deleted via this endpoint
3. **Logging**: All deletion attempts are logged for audit purposes
4. **Validation**: Input data is validated before processing

## Notes
- This action is **irreversible** - once a user is deleted, they cannot be recovered
- The endpoint does not require authentication token (user authenticates with email/password)
- Super admin users are protected and cannot be deleted through this endpoint
- All deletion activities are logged in the application logs

## Web Interface Alternative
Users can also delete their accounts through the web interface at:
```
https://rpropertyhub.com/delete-user?email=user@example.com&password=userpassword123
```

## Testing
To test the API endpoint, you can use:
- Postman
- cURL
- Any HTTP client library (Axios, Fetch, etc.)

Make sure to use valid credentials for testing.
