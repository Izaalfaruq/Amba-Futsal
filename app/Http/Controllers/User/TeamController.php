<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $usersToInvite = User::whereNotIn('id', auth()->user()->teams->pluck('id'))->get();
        return view('user.teams.index', compact('teams', 'usersToInvite'));
    }

    public function create()
    {
        return view('user.teams.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:teams',
            ]);

            $team = Team::create([
                'name' => $request->input('name'),
            ]);

            $team->users()->attach(Auth::id(), ['is_creator' => true]);

            return redirect()->route('user.teams.index')->with('success', 'Team created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('user.teams.create')->with('error', 'Error creating the team. Please try again.');
        }
    }

    public function joinTeam(Team $team)
    {
        $user = Auth::user();

        // Check if the user is already a member of 5 teams
        if ($user->teams->count() >= 5) {
            return redirect()->route('user.teams.index')->with('error', 'You cannot join more than 5 teams. Please leave a team before joining another.');
        }
        // Check if the user is already a member of the team
        if ($team->users->contains($user->id)) {
            return redirect()->route('user.teams.index')->with('error', 'You are already a member of this team.');
        }
        // Add the authenticated user to the team
        $team->users()->attach($user->id);

        return redirect()->route('user.teams.index')->with('success', 'Joined the team successfully.');
    }


    public function leaveTeam(Team $team)
    {
        // Remove the authenticated user from the team
        $team->users()->detach(Auth::id());

        return redirect()->route('user.teams.index')->with('success', 'Left the team successfully.');
    }

    public function inviteUser(Request $request, Team $team)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            // Add other validation rules as needed
        ]);

        $userToInvite = User::where('email', $request->input('email'))->first();

        // Add the user to the team
        $team->users()->attach($userToInvite->id);

        return redirect()->route('user.teams.index')->with('success', 'User invited to the team successfully.');
    }
}
