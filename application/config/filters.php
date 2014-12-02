<?php

// types of filters get|post|ajax|auth|token|*

// request base filters
\Filter::request('*', 'get|post'); // for all actions
\Filter::request('*.delete', 'get|token');

// ip filters
\Filter::ip('*', '*');
