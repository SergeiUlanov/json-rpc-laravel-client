@extends('layouts.main')

@section('title', 'Response')

@section('content')

    <h1>Response object</h1>

    <p>When a rpc call is made, the Server MUST reply with a Response, except for in the case of Notifications.
       The Response is expressed as a single JSON Object, with the following members:</p>

    <ul>
        <li><b>jsonrpc</b> - A String specifying the version of the JSON-RPC protocol. MUST be exactly "2.0".</li>

        <li><b>result</b> - This member is REQUIRED on success.
            This member MUST NOT exist if there was an error invoking the method.
            The value of this member is determined by the method invoked on the Server.</li>

        <li><b>error</b> - This member is REQUIRED on error.
            This member MUST NOT exist if there was no error triggered during invocation.
            The value for this member MUST be an Object as defined in section 5.1.</li>

        <li><b>id</b> - This member is REQUIRED. It MUST be the same as the value of the id member in the Request Object.
            If there was an error in detecting the id in the Request object (e.g. Parse error/Invalid Request), it MUST be Null.</li>
    </ul>

    <p>Either the result member or error member MUST be included, but both members MUST NOT be included.</p>

@stop
