<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->get('username'), 'password' => $request->get('password')])) {
            return json_encode(['result' => 'success', 'user' => Auth::user(), 'token' => Auth::user()->createToken(env('APP_NAME', 'Laravel'))->accessToken]);
        } else {
            return json_encode(['result' => 'error', 'error' => 'El usuario y/o la contraseña son incorrectos']);
        }

    }

    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'El nombre de usuario ya está en uso',
            'password.required' => 'La contraseña es requerida'
        ];
    }


    public function filter(Request $request, $related = false)
    {
        if (Auth::check() && Auth::user()->role->name=='administrador') {
            $data = '';

            foreach ($request->all() as $key => $value){
                if ($data == '') {
                    $data = User::where($key, $value);
                } else {
                    $data = $data->where($key, $value);
                }
            }

            if ($related) {
                $related = unserialize($related);
                $data = $data->with($related);
            }

            return json_encode(['result' => 'success', 'data' => $data->where('type', 1)->where('username', '!=', 'master')->orderBy('id', 'desc')->get()]);
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
        if (Auth::check() && Auth::user()->role->name=='administrador') {
            $data['result'] = 'success';
            if ($related) {
                $related = unserialize($related);
                $data['data'] = User::with($related)->orderBy('id', 'desc')->paginate(10);
            } else {
                $data['data'] = User::orderBy('id', 'desc')->paginate(10);
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id',

        ], $this->messages()
        );
        if ($validator->fails()) {
            return json_encode(['result' => 'error', 'error' => $validator->errors()]);

        }
        if (Auth::check() && Auth::user()->role->name=='administrador') {
            $u = new User();
            $u->name = $request->get('name');
            $u->email = $request->get('email');
            $u->role_id = $request->get('role_id');
            $u->password = bcrypt($request->get('password'));
            $u->status = 1;
            $u->save();
            if ($request->hasFile('image')) {
                $result = $this->create_file($request->file('image'), 'users/' . $u->id);
            }


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
        if (Auth::check() && Auth::user()->role->name=='administrador') {
            $data = false;

            if ($related) {
                $related = unserialize($related);
                $data = User::with($related)->find($id);
            } else {
                $data = User::find($id);
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
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'role_id' => 'required|exists:roles,id',

        ], $this->messages()
        );
        if ($validator->fails()) {
            return json_encode(['result' => 'error', 'error' => $validator->errors()]);

        }
        if (Auth::check() && Auth::user()->role->name=='administrador') {
            $u = User::find($id);
            $u->name = $request->input('name');
            $u->email = $request->input('email');
            $u->role_id = $request->input('role_id');
            if ($request->input('password')!='') {
                $u->password = bcrypt($request->input('password'));
            }
            $u->status = 1;
            $u->save();

            if ($request->hasFile('image')) {
                $result = $this->create_file($request->file('image'), 'users/' . $u->id);
            }

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
        if (Auth::check() && Auth::user()->id != $id && Auth::user()->role->name=='administrador') {
            $u = User::find($id);
            $u->status = $u->status == 1 ? 0 : 1;
            $u->save();
            return json_encode(['result' => 'success']);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);


    }
}
