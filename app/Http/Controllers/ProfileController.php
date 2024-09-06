<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    // Method to display the user's profile
    public function show() {
        return view('profile', ['user' => Auth::user()]);
    }

     // Method to update the user's profile information (name and email)
    public function update(Request $request) {
    // Validate the input (name and email), checking if email is unique
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,' .Auth::id(),
        ]);

        // Get the currently authenticated user
        $user =Auth::user();
        // Update the user's name and email with the input values
        $user ->name = $request->name;
        $user ->email = $request->email;
        // Save the updated user information to the database
        $user ->save();

        return redirect()->back()->with('success', 'Information was updated.');
    }

    // Method to update the user's password
    public function updatePassword(Request $request) {
    // Validate the input: check if the current password is provided, and new password meets criteria
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the provided current password matches the user's actual current password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Incorrect password.']);

        }
        // Update the user's password to the newly provided password (hash it before saving)
        $user = Auth::user();
        $user ->password = Hash::make($request->password);
        // Save the new password to the database
        $user ->save();

        // Redirect back to the profile page with a success message
        return redirect()->back()->with('success', 'Password was updated.');
    }

    // Method to update the user's profile picture
    public function updatePicture(Request $request) {
        $request->validate([
            // Validate the uploaded file: it must be an image and the file size should not exceed 2MB
            'profile_picture' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',

        ]);

        // Get the currently authenticated user
        $user = Auth::user();
        // Create a unique image name using the current timestamp and the image's extension
        $imageName = time() . '.' .$request->profile_picture->extension();
        // Move the uploaded image to the public/images directory
        $request->profile_picture->move(public_path('images'), $imageName);

        // Update the user's profile picture with the new image name
        $user->profile_picture = $imageName;
        // Save the updated user profile picture to the database
        $user->save();
        // Redirect back to the profile page with a success message "Profile photo was updated".
        return redirect()->back()->with('success', 'Profile photo was updated.');
    }
}
