<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display the movies management page
     */
    public function index(Request $request)
    {
        $storagePath = 'movies.json';
        if (!Storage::disk('local')->exists($storagePath)) {
            Storage::disk('local')->put($storagePath, json_encode([
            [
                'id' => 1,
                'title' => 'Avatar: The Way of Water',
                'genre' => 'Sci-Fi, Action',
                'director' => 'James Cameron',
                'cast' => 'Sam Worthington, Zoe Saldana, Sigourney Weaver',
                'duration' => 192,
                'release_date' => '2022-12-16',
                'status' => 'đang chiếu',
                'language' => 'English',
                'country' => 'USA',
                'description' => 'Set more than a decade after the events of the first film, Avatar: The Way of Water begins to tell the story of the Sully family.',
                'poster' => 'https://via.placeholder.com/300x450/1f2937/ffffff?text=Avatar+2',
                'trailer' => 'https://www.youtube.com/watch?v=d9MyW72ELq0',
                'rating' => 8.2,
                'tickets_sold' => 1250,
                'revenue' => 187500000
            ],
            [
                'id' => 2,
                'title' => 'Black Panther: Wakanda Forever',
                'genre' => 'Action, Adventure',
                'director' => 'Ryan Coogler',
                'cast' => 'Letitia Wright, Angela Bassett, Tenoch Huerta',
                'duration' => 161,
                'release_date' => '2022-11-11',
                'status' => 'đang chiếu',
                'language' => 'English',
                'country' => 'USA',
                'description' => 'Queen Ramonda, Shuri, M\'Baku, Okoye and the Dora Milaje fight to protect their nation from intervening world powers.',
                'poster' => 'https://via.placeholder.com/300x450/1f2937/ffffff?text=Black+Panther+2',
                'trailer' => 'https://www.youtube.com/watch?v=_Z3QKkl1WyM',
                'rating' => 7.8,
                'tickets_sold' => 980,
                'revenue' => 147000000
            ],
            [
                'id' => 3,
                'title' => 'Top Gun: Maverick',
                'genre' => 'Action, Drama',
                'director' => 'Joseph Kosinski',
                'cast' => 'Tom Cruise, Miles Teller, Jennifer Connelly',
                'duration' => 131,
                'release_date' => '2022-05-27',
                'status' => 'đã kết thúc',
                'language' => 'English',
                'country' => 'USA',
                'description' => 'After thirty years, Maverick is still pushing the envelope as a top naval aviator.',
                'poster' => 'https://via.placeholder.com/300x450/1f2937/ffffff?text=Top+Gun+2',
                'trailer' => 'https://www.youtube.com/watch?v=qSqVVswa420',
                'rating' => 8.5,
                'tickets_sold' => 2100,
                'revenue' => 315000000
            ],
            [
                'id' => 4,
                'title' => 'Spider-Man: No Way Home',
                'genre' => 'Action, Adventure',
                'director' => 'Jon Watts',
                'cast' => 'Tom Holland, Zendaya, Benedict Cumberbatch',
                'duration' => 148,
                'release_date' => '2021-12-17',
                'status' => 'đã kết thúc',
                'language' => 'English',
                'country' => 'USA',
                'description' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help.',
                'poster' => 'https://via.placeholder.com/300x450/1f2937/ffffff?text=Spider-Man',
                'trailer' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
                'rating' => 8.4,
                'tickets_sold' => 1850,
                'revenue' => 277500000
            ],
            [
                'id' => 5,
                'title' => 'The Batman',
                'genre' => 'Action, Crime',
                'director' => 'Matt Reeves',
                'cast' => 'Robert Pattinson, Zoë Kravitz, Paul Dano',
                'duration' => 176,
                'release_date' => '2022-03-04',
                'status' => 'sắp chiếu',
                'language' => 'English',
                'country' => 'USA',
                'description' => 'When a sadistic serial killer begins murdering key political figures in Gotham.',
                'poster' => 'https://via.placeholder.com/300x450/1f2937/ffffff?text=The+Batman',
                'trailer' => 'https://www.youtube.com/watch?v=mqqft2x_Aa4',
                'rating' => 0,
                'tickets_sold' => 0,
                'revenue' => 0
            ]
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
        $movies = json_decode(Storage::disk('local')->get($storagePath), true) ?: [];

        // Filter movies based on search
        $search = $request->get('search');
        $status = $request->get('status');
        $genre = $request->get('genre');

        if ($search) {
            $movies = array_filter($movies, function($movie) use ($search) {
                return stripos($movie['title'], $search) !== false || 
                       stripos($movie['director'], $search) !== false ||
                       stripos($movie['cast'], $search) !== false;
            });
        }

        if ($status && $status !== 'all') {
            $movies = array_filter($movies, function($movie) use ($status) {
                return $movie['status'] === $status;
            });
        }

        if ($genre && $genre !== 'all') {
            $movies = array_filter($movies, function($movie) use ($genre) {
                return stripos($movie['genre'], $genre) !== false;
            });
        }

        // Get unique genres for filter
        $allGenres = ['Action', 'Adventure', 'Sci-Fi', 'Drama', 'Crime', 'Comedy', 'Horror', 'Thriller'];

        return view('admin.movies', compact('movies', 'allGenres'));
    }

    /**
     * Show the form for creating a new movie
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created movie
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'cast' => 'required|string|max:500',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'status' => 'required|in:đang chiếu,sắp chiếu,đã kết thúc',
            'language' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'poster' => 'nullable|url',
            'trailer' => 'nullable|url'
        ]);
        $storagePath = 'movies.json';
        $movies = Storage::disk('local')->exists($storagePath)
            ? json_decode(Storage::disk('local')->get($storagePath), true) ?: []
            : [];

        // Assign the smallest available positive integer ID starting from 1
        $used = array_map(fn($m)=> (int)($m['id'] ?? 0), $movies);
        $newId = 1;
        sort($used);
        foreach ($used as $u) { if ($u === $newId) { $newId++; } elseif ($u > $newId) { break; } }
        $movies[] = [
            'id' => $newId,
            'title' => $request->input('title'),
            'genre' => $request->input('genre'),
            'director' => $request->input('director'),
            'cast' => $request->input('cast'),
            'duration' => (int)$request->input('duration'),
            'release_date' => $request->input('release_date'),
            'status' => $request->input('status'),
            'language' => $request->input('language'),
            'country' => $request->input('country'),
            'description' => $request->input('description'),
            'poster' => $request->input('poster'),
            'trailer' => $request->input('trailer'),
            // Derived/initial fields
            'rating' => 0,
            'tickets_sold' => 0,
            'revenue' => 0,
        ];

        Storage::disk('local')->put($storagePath, json_encode($movies, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return redirect()->route('admin.movies')->with('success', 'Phim mới đã được thêm thành công!');
    }

    /**
     * Show the form for editing a movie
     */
    public function edit($id)
    {
        $storagePath = 'movies.json';
        $movies = Storage::disk('local')->exists($storagePath)
            ? json_decode(Storage::disk('local')->get($storagePath), true) ?: []
            : [];
        $movie = collect($movies)->firstWhere('id', (int)$id);
        if (!$movie) {
            return redirect()->route('admin.movies')->with('error', 'Không tìm thấy phim để sửa.');
        }
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'cast' => 'required|string|max:500',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'status' => 'required|in:đang chiếu,sắp chiếu,đã kết thúc',
            'language' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'poster' => 'nullable|url',
            'trailer' => 'nullable|url'
        ]);

        $storagePath = 'movies.json';
        $movies = Storage::disk('local')->exists($storagePath)
            ? json_decode(Storage::disk('local')->get($storagePath), true) ?: []
            : [];

        // Find movie index
        $idx = null;
        foreach ($movies as $i => $m) {
            if ((int)$m['id'] === (int)$id) { $idx = $i; break; }
        }
        if ($idx === null) {
            return redirect()->route('admin.movies')->with('error', 'Không tìm thấy phim để cập nhật.');
        }

        // Update allowed fields, keep others intact if not in form
        $fields = ['title','genre','director','cast','duration','release_date','status','language','country','description','poster','trailer'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $movies[$idx][$field] = $request->input($field);
            }
        }

        Storage::disk('local')->put($storagePath, json_encode($movies, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

        return redirect()->route('admin.movies')->with('success', 'Thông tin phim đã được cập nhật thành công!');
    }

    /**
     * Remove the specified movie
     */
    public function destroy($id)
    {
        $storagePath = 'movies.json';
        $movies = Storage::disk('local')->exists($storagePath)
            ? json_decode(Storage::disk('local')->get($storagePath), true) ?: []
            : [];
        $movies = array_values(array_filter($movies, function($m) use ($id){ return (int)$m['id'] !== (int)$id; }));
        Storage::disk('local')->put($storagePath, json_encode($movies, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return redirect()->route('admin.movies')->with('success', 'Phim đã được xóa thành công!');
    }

    /**
     * Get movie statistics
     */
    public function statistics()
    {
        // Sample statistics data
        $stats = [
            'total_movies' => 5,
            'movies_showing' => 2,
            'movies_coming_soon' => 1,
            'movies_ended' => 2,
            'total_tickets_sold' => 6180,
            'total_revenue' => 927000000,
            'top_movie' => 'Top Gun: Maverick',
            'top_movie_revenue' => 315000000
        ];

        return response()->json($stats);
    }
}
