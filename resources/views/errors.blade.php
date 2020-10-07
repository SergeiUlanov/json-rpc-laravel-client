@extends('layouts.main')

@section('title', 'Errors')

@section('content')

    <h1>Error object</h1>

    <p>When a rpc call encounters an error, the Response Object MUST contain the error member
        with a value that is a Object with the following members:</p>
    <ul>
        <li><b>code</b> - A Number that indicates the error type that occurred. This MUST be an integer.</li>
        <li><b>message</b> - A String providing a short description of the error.
            The message SHOULD be limited to a concise single sentence.
        <li><b>data</b> - A Primitive or Structured value that contains additional information about the error.
            This may be omitted.
            The value of this member is defined by the Server (e.g. detailed error information, nested errors etc.).</li>
    </ul>
    <p>The error codes from and including -32768 to -32000 are reserved for pre-defined errors.
        Any code within this range, but not defined explicitly below is reserved for future use.
        The error codes are nearly the same as those suggested for XML-RPC at the following
        url: http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php</p>
    <table>
        <tr><th>code</th><th>message</th><th>meaning</th></tr>
        <tr><td>-32700</td><td>Parse error</td><td>Invalid JSON was received by the server. An error occurred on the server while parsing the JSON text.</td></tr>
        <tr><td>-32600</td><td>Invalid Request</td><td>The JSON sent is not a valid Request object.</td></tr>
        <tr><td>-32601</td><td>Method not found</td><td>The method does not exist / is not available.</td></tr>
        <tr><td>-32602</td><td>Invalid params</td><td>Invalid method parameter(s).</td></tr>
        <tr><td>-32603</td><td>Internal error</td><td>Internal JSON-RPC error.</td></tr>
        <tr><td>-32000 to -32099</td><td>Server error</td><td>Reserved for implementation-defined server-errors.</td></tr>
    </table>
    <p>The remainder of the space is available for application defined errors.</p>

@stop
