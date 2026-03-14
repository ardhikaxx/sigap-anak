@extends('mobile.layout.master')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="mobile-content pt-0">
  <div class="greeting-card mb-4" style="border-radius: 0 0 30px 30px; margin: 0 -16px; padding: 40px 24px 30px;">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('mobile.konsultasi.index') }}" class="avatar-circle bg-glass shadow-none" style="width: 40px; height: 40px; color: white; text-decoration: none;">
        <i class="fas fa-arrow-left"></i>
      </a>
      <div class="flex-grow-1">
        <h1 class="greeting-name mb-0" style="font-size: 1.1rem;">{{ $konsultasi->topik }}</h1>
        <div class="user-meta text-white opacity-75" style="font-size: 0.75rem;">Anak: {{ $konsultasi->anak->nama ?? 'Umum' }}</div>
      </div>
      <span class="badge-custom bg-glass text-white px-3 text-capitalize" style="font-size: 0.7rem;">
        {{ $konsultasi->status }}
      </span>
    </div>
  </div>

  <div class="chat-container mb-4">
    <div class="d-flex flex-column gap-3">
      <!-- Original Question -->
      <div class="chat-bubble sender">
        <div class="bubble-content shadow-sm">
          <div class="fw-bold mb-1" style="font-size: 0.7rem; opacity: 0.7;">{{ $konsultasi->user->name }}</div>
          {{ $konsultasi->pertanyaan }}
          <div class="text-end mt-1" style="font-size: 0.65rem; opacity: 0.5;">
            {{ $konsultasi->created_at->format('H:i') }}
          </div>
        </div>
      </div>

      <!-- Messages Loop -->
      @foreach($konsultasi->pesan as $pesan)
        @php $isMe = $pesan->pengirim_id === auth()->id(); @endphp
        <div class="chat-bubble {{ $isMe ? 'sender' : 'receiver' }}">
          <div class="bubble-content shadow-sm {{ $isMe ? 'bg-primary text-white' : 'bg-white' }}">
            @if(!$isMe)
              <div class="fw-bold mb-1" style="font-size: 0.7rem; color: var(--sigap-primary);">{{ $pesan->pengirim->name }}</div>
            @endif
            {{ $pesan->pesan }}
            <div class="text-end mt-1" style="font-size: 0.65rem; opacity: 0.6;">
              {{ $pesan->created_at->format('H:i') }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @if($konsultasi->status !== 'selesai')
    <div class="fixed-bottom p-3 bg-glass border-top" style="bottom: 70px; z-index: 900;">
      <form action="{{ route('mobile.konsultasi.message', $konsultasi->id) }}" method="POST">
        @csrf
        <div class="input-group">
          <textarea name="pesan" class="form-control border-0 bg-light rounded-4 px-3 py-2" rows="1" placeholder="Tulis pesan Anda..." required style="resize: none;"></textarea>
          <button type="submit" class="btn btn-primary rounded-circle ms-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  @else
    <div class="card-custom bg-light p-4 text-center border-0 mb-5">
      <i class="fas fa-lock text-muted mb-2 fs-4"></i>
      <h6 class="fw-bold text-dark mb-1">Diskusi Telah Selesai</h6>
      <p class="user-meta mb-0" style="font-size: 0.8rem;">Konsultasi ini telah ditutup. Silakan buat konsultasi baru jika masih ada pertanyaan.</p>
    </div>
  @endif
</div>

<style>
  .chat-container {
    padding: 0 4px;
    margin-bottom: 100px;
  }
  .chat-bubble {
    display: flex;
    max-width: 85%;
  }
  .chat-bubble.sender {
    align-self: flex-end;
    margin-left: auto;
  }
  .chat-bubble.receiver {
    align-self: flex-start;
  }
  .bubble-content {
    padding: 12px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    line-height: 1.5;
  }
  .chat-bubble.sender .bubble-content {
    border-bottom-right-radius: 4px;
    background: var(--sigap-primary);
    color: white;
  }
  .chat-bubble.receiver .bubble-content {
    border-bottom-left-radius: 4px;
    background: white;
    color: var(--sigap-dark);
    border: 1px solid var(--sigap-border);
  }
</style>
@endsection
