### Json Exception Handler

This exception handler will run when the underlying request is a Json request.

How do you determine a request is an Json request?

In Laravel, the `Illuminate\Http\Request` object has method called `isJson()` which determines whether the request is
Ajax request or not.  

## Under the hood  

A request called to be a Json request if the Request header has the following header type and value. 

| Header KEY        | Header VALUE                                                             |
|-------------------|--------------------------------------------------------------------------|
| `Content-Type`    | `+json` or `/json`                                                       |


### Output format

```json
[
  'success' => false,
  'message' => $exception->getMessage()
]
```  
### Status code
`Response::HTTP_UNPROCESSABLE_ENTITY = 422`
