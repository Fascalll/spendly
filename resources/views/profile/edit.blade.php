@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4">

    <x-page-header
        title="Profil"
        subtitle="Kelola informasi akun dan foto profilmu."
    />

    <div class="row">
        <div class="col-12 col-lg-7 col-xl-6">

            <div class="card profile-card">
                <div class="card-body p-4">

                    {{-- Profile picture --}}
                    <div class="profile-photo-section mb-4">

                        @if ($user->profile_photo_path)
                            <img
                                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="Foto profil"
                                class="profile-photo-preview"
                            >
                        @else
                            <div class="profile-photo-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted small mb-0">
                                {{ $user->email }}
                            </p>
                        </div>

                    </div>

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                required
                                maxlength="255"
                            >

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                required
                                maxlength="255"
                            >

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Profile photo --}}
                        <div class="mb-4">
                            <label for="profile_photo" class="form-label">
                                Foto profil
                            </label>

                            <input
                                type="file"
                                name="profile_photo"
                                id="profile_photo"
                                class="form-control @error('profile_photo') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <div class="form-text">
                                JPG, PNG, WEBP — maksimal 2 MB.
                            </div>

                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2">

                            @if ($user->profile_photo_path)
                                <button
                                    type="submit"
                                    form="remove-photo-form"
                                    class="btn btn-outline-danger"
                                >
                                    Hapus foto
                                </button>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>
                                Simpan profil
                            </button>

                        </div>

                    </form>

                    {{-- Separate removal form --}}
                    @if ($user->profile_photo_path)
                        <form
                            id="remove-photo-form"
                            action="{{ route('profile.remove-photo') }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus foto profil?')"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
