<?php
namespace CodeClimate\PhpTestReporter\TestReporter\Entity;

use CodeClimate\PhpTestReporter\Constants\Version;
use CodeClimate\PhpTestReporter\System\Git\GitCommand;
use Satooshi\Bundle\CoverallsV1Bundle\Entity\JsonFile as SatooshiJsonFile;
use Satooshi\Bundle\CoverallsV1Bundle\Entity\SourceFile;

class JsonFile extends SatooshiJsonFile
{
	public function toArray()
	{
		return [
			"partial"      => false,
			"run_at"       => $this->getRunAt(),
			"repo_token"   => $this->getRepoToken(),
			"environment"  => $this->getEnvironment(),
			"git"          => $this->collectGitInfo(),
			"ci_service"   => $this->collectCiServiceInfo(),
			"source_files" => $this->collectSourceFiles(),
		];
	}

	public function getRunAt()
	{
		return strtotime( parent::getRunAt() );
	}

	public function getRepoToken()
	{
		return $_SERVER["CODECLIMATE_REPO_TOKEN"];
	}

	protected function getEnvironment()
	{
		return [
			"pwd"             => getcwd(),
			"package_version" => Version::VERSION,
		];
	}

	protected function collectGitInfo()
	{
		$command = new GitCommand();

		return [
			"head"         => $command->getHead(),
			"branch"       => $command->getBranch(),
			"committed_at" => $command->getCommittedAt(),
		];
	}

	protected function collectCiServiceInfo()
	{
		$ciInfo = new CiInfo();

		return $ciInfo->toArray();
	}

	protected function collectSourceFiles()
	{
		$sourceFiles = [ ];

		foreach ( $this->getSourceFiles() as $sourceFile )
		{
			array_push(
				$sourceFiles, [
					"name"     => $sourceFile->getName(),
					"coverage" => json_encode( $sourceFile->getCoverage() ),
					"blob_id"  => $this->calculateBlobId( $sourceFile ),
				]
			);
		}

		return $sourceFiles;
	}

	protected function calculateBlobId( SourceFile $sourceFile )
	{
		$content = file_get_contents( $sourceFile->getPath() );
		$header  = "blob " . strlen( $content ) . "\0";

		return sha1( $header . $content );
	}
}
