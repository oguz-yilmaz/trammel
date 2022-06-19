### Ajax Validation Exception Handler

This exception handler will run when the underlying request is an Ajax request and in the process of that request
when you got a `Illuminate\Validation\ValidationException`.

How do you determine a request is an Ajax request?

In Laravel, the `Illuminate\Http\Request` object has method called `ajax()` which determines whether the request is
Ajax request or not.

## Under the hood

A request called to be a Ajax request if the Request header has the following header type and value.

| Header KEY          | Header VALUE                     |
|---------------------|----------------------------------|
| `X-Requested-With`  | `XMLHttpRequest`                 |    


### Output format

```json
[
  'success' => false,
  'errors'  => $errors,
]
```  
### Status code
`Response::HTTP_UNPROCESSABLE_ENTITY = 422`
