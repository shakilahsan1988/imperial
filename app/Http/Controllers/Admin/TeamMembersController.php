<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\Branch;
use App\Models\TeamMember;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TeamMembersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            if ($isSuper) {
                return $next($request);
            }

            if (! $u || ! $u->hasPermission('view_setting')) {
                abort(403, 'You do not have permission to manage team members.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $teamMembers = TeamMember::with('branch')->ordered()->paginate(20);

        return view('admin.team_members.index', compact('teamMembers'));
    }

    public function create()
    {
        $branches = Branch::orderByRaw('coalesce(title, name)')->get();

        return view('admin.team_members.create', compact('branches'));
    }

    public function store(TeamMemberRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            if (! File::isDirectory('uploads/team_members')) {
                File::makeDirectory('uploads/team_members', 0755, true);
            }
            $image = $request->file('image');
            $imageName = 'member_'.time().'_'.Str::random(5).'.'.$image->getClientOriginalExtension();
            $image->move('uploads/team_members', $imageName);
            $data['image'] = 'uploads/team_members/'.$imageName;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team_members.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $team_member)
    {
        $branches = Branch::orderByRaw('coalesce(title, name)')->get();

        return view('admin.team_members.edit', compact('team_member', 'branches'));
    }

    public function update(TeamMemberRequest $request, TeamMember $team_member)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            if (! File::isDirectory('uploads/team_members')) {
                File::makeDirectory('uploads/team_members', 0755, true);
            }
            if ($team_member->image && File::exists($team_member->image)) {
                File::delete($team_member->image);
            }
            $image = $request->file('image');
            $imageName = 'member_'.time().'_'.Str::random(5).'.'.$image->getClientOriginalExtension();
            $image->move('uploads/team_members', $imageName);
            $data['image'] = 'uploads/team_members/'.$imageName;
        }

        $team_member->update($data);

        return redirect()->route('admin.team_members.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team_member)
    {
        if ($team_member->image && File::exists($team_member->image)) {
            File::delete($team_member->image);
        }

        $team_member->delete();

        return redirect()->route('admin.team_members.index')
            ->with('success', 'Team member deleted successfully.');
    }

    public function ajax()
    {
        $teamMembers = TeamMember::active()->ordered()->get();

        return datatables()->of($teamMembers)
            ->addColumn('action', function ($member) {
                return view('admin.team_members._action', compact('member'));
            })
            ->editColumn('name', function ($member) {
                return '<strong>'.$member->name.'</strong>';
            })
            ->editColumn('status', function ($member) {
                return $member->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->editColumn('image', function ($member) {
                if ($member->image) {
                    return '<img src="'.asset($member->image).'" class="img-thumbnail" style="max-height: 50px;">';
                }

                return '-';
            })
            ->rawColumns(['action', 'name', 'status', 'image'])
            ->make(true);
    }
}
