<!DOCTYPE html>
<html>
<head>
    <title>Votes - {{ $election->titre }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #1d9bf0; color: white; }
    </style>
</head>
<body>
    <h1>Votes pour {{ $election->titre }}</h1>
    <table>
        <thead>
            <tr>
                <th>ID Vote</th>
                <th>Utilisateur</th>
                <th>Candidat</th>
                <th>Date du vote</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($votes as $vote)
                <tr>
                    <td>{{ $vote->id_vote }}</td>
                    <td>{{ $vote->utilisateur->nom }}</td>
                    <td>{{ $vote->candidat->nom }}</td>
                    <td>{{ $vote->date_vote }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
