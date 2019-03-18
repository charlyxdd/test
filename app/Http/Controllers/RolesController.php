<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function messages()
    {
        return [

        ];
    }


    public function filter(Request $request, $related = false)
    {
        if (Auth::check() && Auth::user()->role->name == 'administrador') {
            $data = '';

            foreach ($request->all() as $key => $value) {
                if ($data == '') {
                    $data = Role::where($key, $value);
                } else {
                    $data = $data->where($key, $value);
                }
            }

            if ($related) {
                $related = unserialize($related);
                $data = $data->with($related);
            }

            return json_encode(['result' => 'success', 'data' => $data->orderBy('id', 'desc')->get()]);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene autorización']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($related = false)
    {
        $data = [];
        $data['result'] = 'error';
        if (Auth::check() && Auth::user()->role->name == 'administrador') {
            $data['result'] = 'success';
            if ($related) {
                $related = unserialize($related);
                $data['data'] = Role::with($related)->orderBy('id', 'desc')->paginate(10);
            } else {
                $data['data'] = Role::orderBy('id', 'desc')->paginate(10);
            }
        } else {
            $data['error'] = 'No tiene autorización';
        }
        return json_encode($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \validator(
            $request->all(), [
            'name' => 'required|unique:roles,name'

        ], $this->messages()
        );
        if ($validator->fails()) {
            return json_encode(['result' => 'error', 'error' => $validator->errors()]);

        }
        if (Auth::check() && Auth::user()->role->name == 'administrador') {

            $r = new Role();
            $r->name = $request->input('name');
            $r->status = 1;
            $r->save();

            return json_encode(['result' => 'success']);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $related = false)
    {
        if (Auth::check() && Auth::user()->role->name == 'administrador') {
            $data = false;

            if ($related) {
                $related = unserialize($related);
                $data = Role::with($related)->find($id);
            } else {
                $data = Role::find($id);
            }
            if ($data) {
                return json_encode(["result" => "success", "data" => $data]);
            }
            return json_encode(['result' => 'error', 'error' => ['No hay resultados']]);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \validator(
            $request->all(), [
            'name' => 'required|unique:roles,name,'.$id,

        ], $this->messages()
        );
        if ($validator->fails()) {
            return json_encode(['result' => 'error', 'error' => $validator->errors()]);

        }
        if (Auth::check() && Auth::user()->role->name == 'administrador') {

            $r = Role::find($id);
            $r->name = $request->input('name');
            $r->status = 1;
            $r->save();

            return json_encode(['result' => 'success']);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check() && Auth::user()->role->name == 'administrador') {
            $r = Role::find($id);
            $r->status = $r->status == 1 ? 0 : 1;
            $r->save();
            return json_encode(['result' => 'success']);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);

    }
}
