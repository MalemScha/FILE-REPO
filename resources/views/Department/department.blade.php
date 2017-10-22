{{--<department inline-template :department = "{{ $department }}" >--}}
{{--<div>--}}
<div class="link">
    <div class="left">
        <i class="fa fa-code"></i>
        {{ $department->name }}
    </div>
    <div class="right">
            <span class="mr-1" data-toggle="modal" data-target="#head_Modal">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            </span>

        <span data-toggle="modal" data-target="#dept_Modal">
            <i class="fa fa-pencil dept"></i>
            <i class="fa fa-chevron-down"></i>
        </span>
    </div>
    <div class="clear"></div>
</div>
<ul class="submenu">
    @forelse($users->where('department_id',$department->id) as $user)
        <li>{{ $user->full_name }}</li>
    @empty
        <li>No user in this department</li>
    @endforelse
</ul>


{{--</div>--}}
{{--</department>--}}