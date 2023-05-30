<?php

namespace Souravmsh\CompressedHtml\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompressedHtmlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    { 
        $response = $next($request);

        if (config('compressed-html.enable')) {
            $response = $this->compressedHtml($response);
        }

        return $response;
    }
 

	private function compressedHtml($response)
    { 
		if ($this->isResponseObject($response) && $this->isHtmlResponse($response)) {
			$replace = [
			  '/\>[^\S ]+/s'                                                      => '>',
			  '/[^\S ]+\</s'                                                      => '<',
			  '/([\t ])+/s'                                                       => ' ',
			  '/^([\t ])+/m'                                                      => '',
			  '/([\t ])+$/m'                                                      => '',
			  '~//[a-zA-Z0-9 ]+$~m'                                               => '',
			  '/[\r\n]+([\t ]?[\r\n]+)+/s'                                        => "\n",
			  '/\>[\r\n\t ]+\</s'                                                 => '><',
			  '/}[\r\n\t ]+/s'                                                    => '}',
			  '/}[\r\n\t ]+,[\r\n\t ]+/s'                                         => '},',
			  '/\)[\r\n\t ]?{[\r\n\t ]+/s'                                        => '){',
			  '/,[\r\n\t ]?{[\r\n\t ]+/s'                                         => ',{',
			  '/\),[\r\n\t ]+/s'                                                  => '),',
			  '~([\r\n\t ])?([a-zA-Z0-9]+)=\"([a-zA-Z0-9_\\-]+)\"([\r\n\t ])?~s'  => '$1$2=$3$4', 
			];
			
			$response->setContent(preg_replace(array_keys($replace), array_values($replace), $response->getContent()));
		}

		return $response;
  }

  private function isResponseObject($response)
  {
	  return is_object($response) && $response instanceof Response;
  }

  private function isHtmlResponse(Response $response)
  {
	  return strtolower(strtok($response->headers->get('Content-Type'), ';')) === 'text/html';
  }
}
