@extends('layouts.main')

@section('title', 'Request')

@section('content')

    <h1>Request object</h1>

    <p>A rpc call is represented by sending a Request object to a Server. The Request object has the following members:</p>
    <ul>
        <li><b>jsonrpc</b> - A String specifying the version of the JSON-RPC protocol. MUST be exactly "2.0".</li>
        <li><b>method</b> - A String containing the name of the method to be invoked. Method names that begin with the
            word rpc followed by a period character (U+002E or ASCII 46) are reserved for rpc-internal methods
            and extensions and MUST NOT be used for anything else.</li>
        <li><b>params</b> - A Structured value that holds the parameter values to be used during the invocation of the method.
            This member MAY be omitted.
        <li><b>id</b> - An identifier established by the Client that MUST contain a String, Number, or NULL value if included.
            If it is not included it is assumed to be a notification. The value SHOULD normally not be Null [1]
            and Numbers SHOULD NOT contain fractional parts [2]</li>
    </ul>
    <p>The Server MUST reply with the same value in the Response object if included.
        This member is used to correlate the context between the two objects.</p>

    <p>[1] The use of Null as a value for the id member in a Request object is discouraged, because this specification
        uses a value of Null for Responses with an unknown id. Also, because JSON-RPC 1.0 uses an id value of Null
        for Notifications this could cause confusion in handling.</p>
    <p>[2] Fractional parts may be problematic, since many decimal fractions cannot be represented exactly as binary fractions.</p>

@stop
