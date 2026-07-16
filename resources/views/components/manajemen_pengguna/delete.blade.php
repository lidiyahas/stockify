<form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
</form>