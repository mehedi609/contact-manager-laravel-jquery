<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
  private $rules = [
    'name' => ['required', 'min:5'],
    'company' => ['required'],
    'email' => ['required', 'email'],
    'photo' => ['mimes:jpg,jpeg,png,gif,bmp']
  ];

  private $upload_dir = '';

  public function __construct()
  {
    $this->upload_dir = base_path().'/public/uploads';
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (session('success'))
      Alert::success('Success!', session('success'));

    if ($group_id = ($request->get('group_id'))) {
      $contacts = Contact::where('group_id', $group_id)->orderByDesc('id')->paginate(5);
    } else {
      $contacts = Contact::orderByDesc('id')->paginate(5);
    }

    return view('contacts.index', compact('contacts'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $contact = [];
    return view('contacts.create', compact('contact'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $this->validate($request, $this->rules);

    $data = $this->getRequest($request);

    Contact::create($data);

    return redirect()
      ->route('contacts.index')
      ->with('success', 'Contact Saved');
  }

  private function getRequest(Request $request)
  {
    $data = $request->all();

    if ($request->hasFile('photo')) {
      $photo = $request->file('photo');
      $extension = $photo->getClientOriginalExtension();
      $file_name = Str::uuid() . '.' . $extension;

      $photo->move($this->upload_dir, $file_name);
      $data['photo'] = $file_name;
    }

    return $data;
  }

  private function removeImage($image)
  {
    if (!empty($image)) {
      $file_path = "{$this->upload_dir}/{$image}";
      if (file_exists($file_path))
        unlink($file_path);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Contact $contact
   * @return \Illuminate\Http\Response
   */
  public function show(Contact $contact)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Contact $contact
   * @return \Illuminate\Http\Response
   */
  public function edit(Contact $contact)
  {
    return view('contacts.edit', compact('contact'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Contact $contact
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Contact $contact)
  {
    $this->validate($request, $this->rules);
//        dd('saved.');

    $oldImage = $contact->photo;
    $data = $this->getRequest($request);
    $contact->update($data);

    if ($oldImage !== $contact->photo)
      $this->removeImage($oldImage);

    return redirect()
      ->route('contacts.index')
      ->with('success', 'Contact Updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Contact $contact
   * @return \Illuminate\Http\Response
   */
  public function destroy(Contact $contact)
  {
    $contact->delete();
    $this->removeImage($contact->photo);

    return redirect()
      ->route('contacts.index')
      ->with('success', 'Contact Deleted!');
  }
}
