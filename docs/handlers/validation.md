### Default Validation Exception Handler

This exception handler will run when the underlying request is not an Ajax request or a JSON Request and
when you get a `Illuminate\Validation\ValidationException` in the process the request.

### Output format  

It will be `Illuminate\Http\RedirectResponse` with errors and inputs to the previous page (`via back() method`).  

