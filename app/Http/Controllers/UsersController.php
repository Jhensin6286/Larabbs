<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    
    /**
     * 展示
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));

    }


    /**
     * 编辑
     */
    public function edit(User $user)
    {
        // 添加授权策略：
        $this->authorize('update',$user);
        return view('users.edit', compact('user'));
    }


    /**
     * 上传图片
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        // 添加授权策略：
        $this->authorize('update', $user);
        // 自动验证参数
        $data = $request->all();

        // 假如请求到了头像
        if ($request->avatar) {
            // 执行保存操作
            $result = $uploader->save($request->avatar, 'avatars', $user->id，362);
            // 假如$result为假，通不过后缀名检查，则为false
            if ($result) {
                // 准备存储的是图像的路径
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功~！');
    }
}
