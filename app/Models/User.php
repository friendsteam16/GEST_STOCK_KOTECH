<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        /** @use HasFactory<\Database\Factories\UserFactory> */
        use HasFactory, Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var list<string>
         */
        protected $fillable = [
            'name',
            'email',
            'password',
            'role_id' // <-- Important si tu veux l’enregistrer via formulaire ou seeder
        ];

        public function role()
        
        {
            return $this->belongsTo(Role::class);
        }

        public function hasRole($role)
        {
            return $this->role && $this->role->name === $role;
        }

        public function hasAnyRole(array $roles)
        {
            return $this->role && in_array($this->role->name, $roles);
        }
        
        

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var list<string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * Get the attributes that should be cast.
         *
         * @return array<string, string>
         */
        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ];
        }
    }
