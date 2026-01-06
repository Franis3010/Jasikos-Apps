<<<<<<< HEAD
<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12">
        <div class="w-full max-w-md">
            <div class="bg-white/80 backdrop-blur rounded-2xl shadow-xl border border-gray-100">
                <div class="px-6 pt-8 pb-3 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight">Create Account</h1>
                    <p class="text-sm text-gray-500 mt-1">Sign up to start exploring designs & custom work.</p>
                </div>

                <div class="px-6 pb-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required
                                autofocus autocomplete="name" class="mt-1 block w-full rounded-xl" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autocomplete="username" class="mt-1 block w-full rounded-xl" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" type="password" name="password" required
                                autocomplete="new-password" class="mt-1 block w-full rounded-xl" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Confirm --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                required autocomplete="new-password" class="mt-1 block w-full rounded-xl" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        {{-- Role segmented --}}
                        <div>
                            <label class="block text-sm font-medium">Register as</label>
                            @php $roleOld = old('role','customer'); @endphp

                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <label class="role-option">
                                    <input class="sr-only" type="radio" name="role" value="customer"
                                        {{ $roleOld === 'customer' ? 'checked' : '' }}>
                                    <span>Customer</span>
                                </label>

                                <label class="role-option">
                                    <input class="sr-only" type="radio" name="role" value="designer"
                                        {{ $roleOld === 'designer' ? 'checked' : '' }}>
                                    <span>Designer</span>
                                </label>
                            </div>

                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        {{-- Submit (extra spacing after role) --}}
                        <button type="submit" class="btn-register">
                            {{ __('Register') }}
                        </button>

                        <div class="text-center text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-gray-900 underline">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Page-only CSS --}}
    <style>
        /* button clearly visible + spacing from role */
        .btn-register {
            display: block;
            width: 100%;
            margin-top: 18px;
            /* extra space after "Designer" */
            padding: 12px 16px;
            border-radius: 12px;
            background: #000;
            color: #fff;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            transition: transform .05s ease, filter .15s ease;
        }

        .btn-register:hover {
            filter: brightness(0.95);
        }

        .btn-register:active {
            transform: translateY(1px);
        }

        .role-option {
            display: block;
            cursor: pointer;
            user-select: none;
        }

        .role-option span {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: .5rem 1rem;
            font-size: .9rem;
            font-weight: 600;
            color: #111;
            transition: background .2s ease, color .2s ease, border-color .2s ease;
        }

        .role-option:hover span {
            background: #f8f9fa;
        }

        .role-option input:checked+span {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .role-option input:focus-visible+span {
            outline: 2px solid #111;
            outline-offset: 2px;
        }
    </style>
</x-guest-layout>
=======
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-sm">
          <div class="card-header text-center">
            <h4>Create Account</h4>
          </div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" type="text" class="form-control" value="{{ old('name') }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
              </div>
            </form>

            <!-- link back to login -->
            <p class="mt-4 small text-muted">
              Already have an account?
              <a href="{{ route('login') }}" class="text-primary">Login here</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> b83671218a72768156921f193e46e08c4ea4ba4b
